<?php

namespace App\Models\Common;

use RecursiveIteratorIterator;
use RecursiveArrayIterator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use DB;

use Kalnoy\Nestedset\NodeTrait;

use App\Models\Core\Configs;
use App\Traits\ConnectCommonTrait;

class Page extends Model
{
    /**
     * create()やupdate()で入力を受け付ける ホワイトリスト
     */
    protected $fillable = ['page_name', 'permanent_link', 'background_color', 'header_color', 'theme',  'layout', 'base_display_flag', 'ip_address', 'othersite_url', 'othersite_url_target', 'class'];

    use NodeTrait;
    use ConnectCommonTrait;

    /**
     *  言語設定があれば、特定の言語ページのみに絞る
     *
     */
    public static function getPageIds($current_page_obj = null, $menu = null, $setting_mode = false)
    {
        $page_ids = array();
        $pages = self::getPages($current_page_obj, $menu, $setting_mode);
        foreach($pages as $page) {
            $page_ids[] = $page->id; 
        }
        return $page_ids;
    }

    /**
     *  言語設定があれば、特定の言語ページのみに絞る
     *
     */
    public static function getPages($current_page_obj = null, $menu = null, $setting_mode = false)
    {
        // current_page_obj がない場合は、ページデータを全て取得（管理画面など）
        // 表示順は入れ子集合モデルの順番
        if (empty($current_page_obj)) {
            return self::defaultOrder()->get();
        }

        // メニューで表示するページが絞られている場合は、選択したページのみ取得する。
        $where_page_ids = array();
        if (!empty($menu) && $menu->select_flag == 1 && !empty($menu->page_ids)) {
            $where_page_ids = explode(',', $menu->page_ids);
        }

        // 多言語の使用有無取得
        $language_multi_on_record = Configs::where('name', 'language_multi_on')->first();
        $language_multi_on = ($language_multi_on_record) ? $language_multi_on_record->value : null;

        // 多言語モードでない場合 or 設定モードの場合 は表示設定されているページデータを全て取得
        if (!$language_multi_on || $setting_mode) {

            return self::defaultOrder()->where(function ($query_menu) use ($where_page_ids) {
                             // メニューによるページ選択
                             if (!empty($where_page_ids)) {
                                 $query_menu->whereIn('id', $where_page_ids);
                             }
                         })->get();
        }

        // 使用する言語リストの取得
        $languages = Configs::where('category', 'language')->orderBy('additional1', 'asc')->get();

        // 現在の言語
        $current_language = null;

        // 今、表示しているページの言語を判定
        $current_page_paths = explode('/', $current_page_obj['permanent_link']);
        if ($current_page_paths && is_array($current_page_paths) && array_key_exists(1, $current_page_paths)) {
            foreach($languages as $language) {
                if (trim($language->additional1, '/') == $current_page_paths[1]) {
                    $current_language = $current_page_paths[1];
                    break;
                }
            }
        }
        //echo $current_language;

        // 表示言語がデフォルトなら、多言語のページを表示しない。多言語なら、その言語のみに絞り込む。
        // デフォルトの場合、言語設定にある他の言語のpermanent_link を対象外にする。
        if (empty($current_language)) {
            $ret = self::defaultOrder()
                       ->where(function ($query) use ($languages) {
                           foreach($languages as $language) {
                               if ($language->additional1 == '/') {
                                   // デフォルト言語 "/" は表示するので、除外の対象外
                                   continue;
                               }
                               $query->where('permanent_link', 'not like', $language->additional1 . '%');
                           }
                       })
                       ->where(function ($query_menu) use ($where_page_ids) {
                           // メニューによるページ選択
                           if (!empty($where_page_ids)) {
                               $query_menu->whereIn('id', $where_page_ids);
                           }
                       })
                       ->get();

//Log::debug(json_encode( $ret, JSON_UNESCAPED_UNICODE));

            return $ret;
        }
        else {
            return self::defaultOrder()
                       ->where(function ($query_lang) use ($current_language) {
                           // 多言語トップページは /en のように後ろに / がない。 /en* だと、/env なども拾ってしまう。
                           $query_lang->where('permanent_link', 'like', '/' . $current_language . '/%')
                                      ->orWhere('permanent_link', '/' . $current_language);
                       })
                       ->where(function ($query_menu) use ($where_page_ids) {
                           // メニューによるページ選択
                           if (!empty($where_page_ids)) {
                               $query_menu->whereIn('id', $where_page_ids);
                           }
                       })
                       ->get();
        }
    }

    /**
     *  ページデータ取得＆深さの追加関数
     *
     * @param int $frame_id
     * @return view
     */
    public static function defaultOrderWithDepth($format = null, $current_page_obj = null, $menu = null, $setting_mode = false)
    {

        // ページデータを全て取得
        // 表示順は入れ子集合モデルの順番
        // メニューの表示チェックは、読むデータを絞るものではなく、表示のON/OFF に使用する。（本来の階層は維持する）
        //$pages = self::getPages($current_page_obj, $menu, $setting_mode);
        $pages = self::getPages($current_page_obj, null, $setting_mode);

        //Log::debug($pages);

        // メニューの階層を表現するために、一度ツリーにしたものを取得し、クロージャで深さを追加
        $tree = $pages->toTree();
        //Log::debug(json_encode( $tree, JSON_UNESCAPED_UNICODE));

        // メニューが選択表示＆表示選択データが渡されたら
        $where_page_ids = null;
        if (!empty($menu) && $menu->select_flag == 1) {
            $where_page_ids = explode(',', $menu->page_ids);
        }

        // クロージャでページ配列を再帰ループし、深さを追加する。
        // テンプレートでは深さをもとにデザイン処理する。
        $traverse = function ($pages, $prefix = '-', $depth = -1, $display_flag = 1) use (&$traverse, $where_page_ids, $menu) {
            $depth = $depth+1;
            foreach ($pages as $page) {
                $page->depth = $depth;
                //$page->page_name = $page->page_name;

                // 表示フラグを親を引き継いで保持
                // 表示フラグはローカル変数に保持して、子要素の再帰呼び出し処理へ引き継ぐ
                // (自身のページの表示/非表示はこの後、メニュー設定で変更されるため)

                // メニュー設定を見ない or メニュー設定でページ設定の条件を使用するとなっている場合は、基本表示フラグを反映
                if (empty($menu) || $menu->select_flag === 0) {
                    $page_display_flag = ($page->base_display_flag == 0 || $display_flag == 0 ? 0 : 1);
                }
                else {
                    $page_display_flag = ($display_flag == 0 ? 0 : 1);
                }
                $page->display_flag = $page_display_flag;

                // メニュー設定からの表示/非表示の反映(メニューが選択表示＆選択されていなかったら display_flag に 0 を)
                if (!empty($where_page_ids) && !in_array($page->id, $where_page_ids)) {
                    $page->display_flag = 0;
                }

                // 再帰呼び出し(表示フラグはメニュー設定の反映されていないページ情報のものを渡す)
                $traverse($page->children, $prefix.'-', $depth, $page_display_flag);
            }
        };
        $traverse($tree);

        if ( $format == 'flat' ) {
            return $pages;
        }

        //Log::debug(json_encode( $tree, JSON_UNESCAPED_UNICODE));
        return $tree;
    }

    /**
     *  クラス名取得
     *
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     *  リンク用URL取得
     *
     */
    public function getLinkUrl($trim_str = null)
    {
        if ($trim_str == null) {
            return $this->permanent_link;
        }

        return trim($this->permanent_link, $trim_str);
    }

    /**
     *  CSS セレクタ用クラス用取得
     *
     */
    public function getPermanentlinkClassname()
    {
        if (empty(trim($this->permanent_link, '/'))) {
            return "home";
        }
        return str_replace('/', '-', trim($this->permanent_link, '/'));
    }

    /**
     *  表示可否の判断
     *
     */
    public function isView($check_ip_only = false)
    {
        // displayフラグ（ページの継承を加味した値）が 0 なら非表示
        if ($check_ip_only == false && $this->display_flag == 0) {
            return false;
        }

        // IP アドレス制限があれば、IP アドレスチェック
        if (!empty($this->ip_address)) {

            $ip_addresses = explode(',', $this->ip_address);

            foreach($ip_addresses as $ip_address) {
                if ($this->isRangeIp(\Request::ip(), trim($ip_address))) {
                    return true;
                }
            }
        }
        return true;
        return false;
    }

    /**
     *  ページのURLを返す
     *
     */
    public function getUrl()
    {
        if (!empty($this->othersite_url)) {
            return $this->othersite_url;
        }
        return url("/") . $this->permanent_link;
    }

    /**
     *  ページのリンク用target タグを返す
     *
     */
    public function getUrlTargetTag()
    {
        $return_str = '';
        if ($this->othersite_url_target) {
            $return_str .= 'target="_blank"';
        }

        return $return_str;
    }
}
