<?php
namespace App\Plugins\Manage\HolidayManage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Common\Holiday;
use App\Models\Common\YasumiHoliday;
use App\Models\Core\Configs;

use Carbon\Carbon;

use App\Plugins\Manage\ManagePluginBase;

/**
 * 祝日管理クラス
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @author 牟田口 満 <mutaguchi@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category 祝日管理
 * @package Controller
 * @plugin_title 祝日管理
 * @plugin_desc 祝日に関する機能が集まった管理機能です。
 */
class HolidayManage extends ManagePluginBase
{
    /**
     * 独自設定祝日データ
     * bugfix: php82 - Creation of dynamic property App\Plugins\Manage\HolidayManage\HolidayManage::$post is deprecated 修正
     */
    public $post = null;

    /**
     *  権限定義
     */
    public function declareRole()
    {
        // 権限チェックテーブル
        $role_ckeck_table = array();
        $role_ckeck_table["index"]          = array('admin_site');
        $role_ckeck_table["edit"]           = array('admin_site');
        $role_ckeck_table["overrideEdit"]   = array('admin_site');
        $role_ckeck_table["update"]         = array('admin_site');
        $role_ckeck_table["overrideUpdate"] = array('admin_site');
        $role_ckeck_table["delete"]         = array('admin_site');
        return $role_ckeck_table;
    }

    /**
     * 独自設定祝日データの呼び出し
     */
    private function getPost($id)
    {
        // 独自設定祝日を取得する。
        $this->post = Holiday::firstOrNew(['id' => $id]);
        return $this->post;
    }

    /**
     * 独自設定祝日データの呼び出し
     */
    private function getPostFromDate($date)
    {
        // 独自設定祝日を取得する。
        $this->post = Holiday::firstOrNew(['holiday_date' => $date]);
        return $this->post;
    }

    /**
     * 独自設定祝日データの呼び出し
     */
    private function getPosts($request)
    {
        // 独自設定祝日を取得する。
        return Holiday::where('holiday_date', 'LIKE', $request->session()->get('holiday_year') . '-' .$request->session()->get('holiday_month') . '%')->orderBy('holiday_date')->get();
    }

    /**
     *  年の祝日を取得
     */
    private function getYasumi($date)
    {
        $ymd = explode('-', $date);
        $holidays = YasumiHoliday::getYasumis($ymd[0]);
        $holiday = null;
        foreach ($holidays as $holiday_item) {
            if ($holiday_item->format('Y-m-d') == $date) {
                $holiday = $holiday_item;
                break;
            }
        }
        return $holiday;
    }

    /**
     *  祝日表示
     *
     * @return view
     * @method_title 祝日一覧
     * @method_desc 年毎の祝日を一覧で確認できます。
     * @method_detail 基本は Yasumiライブラリを使用しています。（ <a href="https://github.com/azuyalabs/yasumi" target="_blank">https://github.com/azuyalabs/yasumi</a> ）<br />祝日の基本を変更する場合はYasumiライブラリをメンテナンスすることで対応します。
     */
    public function index($request)
    {
        // Config データの取得
        $configs = Configs::get();

        // Config データの変換
        $configs_array = array();
        foreach ($configs as $config) {
            $configs_array[$config->name] = $config->value;
        }

        // 表示する年のセッション処理
        if ($request->filled('year')) {
            // リクエストに年月が渡ってきたら、セッションに保持しておく。（詳細や更新後に元のページに戻るため）
            $request->session()->put('holiday_year', $request->year);
        } elseif (!session()->has('holiday_year')) {
            // 画面の指定もセッションにも値がなければ当日をセット
            $request->session()->put('holiday_year', date("Y"));
        }

        // 年の祝日一覧を取得する。
        $holidays = YasumiHoliday::getYasumis($request->session()->get('holiday_year'));
        // 独自設定祝日を加味する。
        $holidays = YasumiHoliday::addConnectHolidays($this->getPosts($request), $holidays);

        // 表示年リストの初期値
        $holiday_date_max = Holiday::max('holiday_date');
        if (empty($holiday_date_max)) {
            // 現在年＋１
            $year_list_initial = date("Y") + 1;
        } else {
            $holiday_date_max = new Carbon($holiday_date_max);
            if ($holiday_date_max->year > (date("Y") + 1)) {
                // 登録の最大年
                $year_list_initial = $holiday_date_max->year;
            } else {
                $year_list_initial = date("Y") + 1;
            }
        }

        // 画面の呼び出し
        return view('plugins.manage.holiday.index', [
            "function"    => __FUNCTION__,
            "plugin_name" => "holiday",
            "configs"     => $configs_array,
            "holidays"    => $holidays,
            "year_list_initial" => $year_list_initial,
        ]);
    }

    /**
     *  検索条件設定処理
     */
    public function search($request, $id)
    {
        // 検索ボタンが押されたときはここが実行される。検索条件を設定してindex を呼ぶ。
        // 画面上、検索条件は app_log_search_condition という名前で配列になっているので、
        // app_log_search_condition をセッションに持つことで、条件の持ち回りが可能。
        session(["app_log_search_condition" => $request->input('app_log_search_condition')]);

        return redirect("/manage/log");
    }

    /**
     *  検索条件クリア処理
     */
    public function clearSearch($request, $id)
    {
        // 検索条件をクリアし、index 処理を呼ぶ。
        $request->session()->forget('app_log_search_condition');
        return $this->index($request, $id);
    }

    /**
     *  祝日設定画面
     *
     * @return view
     * @method_title 祝日登録
     * @method_desc 年毎に祝日を追加できます。
     * @method_detail
     */
    public function edit($request, $date)
    {
        // Config データの取得
        $configs = Configs::get();

        // Config データの変換
        $configs_array = array();
        foreach ($configs as $config) {
            $configs_array[$config->name] = $config->value;
        }

        // 独自設定祝日データの呼び出し
        $post = $this->getPost($date);

        // 画面の呼び出し
        return view('plugins.manage.holiday.edit', [
            "function"    => __FUNCTION__,
            "plugin_name" => "holiday",
            "configs"     => $configs_array,
            "post"        => $post,
        ]);
    }

    /**
     *  祝日上書き設定画面
     *
     * @return view
     * @method_title 祝日上書き
     * @method_desc 年毎に祝日を無効にできます。
     * @method_detail
     */
    public function overrideEdit($request, $date)
    {
        // Config データの取得
        $configs = Configs::get();

        // Config データの変換
        $configs_array = array();
        foreach ($configs as $config) {
            $configs_array[$config->name] = $config->value;
        }

        // 計算した祝日データの呼び出し
        $holiday = $this->getYasumi($date);
        // 独自設定祝日データの呼び出し
        $post = $this->getPostFromDate($date);

        // 画面の呼び出し
        return view('plugins.manage.holiday.override_edit', [
            "function"    => __FUNCTION__,
            "plugin_name" => "holiday",
            "configs"     => $configs_array,
            "holiday"     => $holiday,
            "post"        => $post,
        ]);
    }

    /**
     *  祝日設定更新
     */
    public function update($request)
    {
        // httpメソッド確認
        if (!$request->isMethod('post')) {
            abort(403, '権限がありません。');
        }

        // 項目のエラーチェック
        $validator = Validator::make($request->all(), [
            'holiday_date'     => 'required|date',
            'holiday_name'     => 'required',
        ]);
        $validator->setAttributeNames([
            'holiday_date'     => '日付',
            'holiday_name'     => '祝日名',
        ]);

        // エラーがあった場合は入力画面に戻る。
        if ($validator->fails()) {
            return redirect('manage/holiday/edit/')
                       ->withErrors($validator)
                       ->withInput();
        }

        // 祝日の追加
        // 計算の祝日の無効化

        // 日付で取得。なければ追加として新規オブジェクト
        // 日付で取得することで、登録ですでにある日を選んでも更新として扱う。
        $holiday = Holiday::firstOrNew(['holiday_date' => $request->holiday_date]);

        $holiday->holiday_date = $request->holiday_date;
        $holiday->holiday_name = $request->holiday_name;
        $holiday->holiday_key  = $request->filled('holiday_key') ? $request->holiday_key : $request->holiday_date;
        $holiday->status       = $request->status;
        $holiday->save();

        // 祝日一覧画面に戻る
        return redirect("/manage/holiday");
    }

    /**
     *  祝日設定上書き
     */
    public function overrideUpdate($request)
    {
        // httpメソッド確認
        if (!$request->isMethod('post')) {
            abort(403, '権限がありません。');
        }

        // 日付で取得。なければ追加として新規オブジェクト
        // 追加での登録データ
        $holiday = Holiday::firstOrNew(['holiday_date' => $request->holiday_date]);
        // 計算データ
        $calc_holiday = $this->getYasumi($request->holiday_date);

        // 「この祝日を無効にする。」の場合、無効レコードの追加
        // 「無効を解除して有効に戻す。」の場合、無効レコードの削除

        if ($request->status == '1') {
            // 「この祝日を無効にする。」
            $holiday->holiday_date = $calc_holiday->format('Y-m-d');
            $holiday->holiday_name = $calc_holiday->getName();
            $holiday->holiday_key  = $calc_holiday->shortName;
            $holiday->status       = 1;
            $holiday->save();
        } else {
            // 「無効を解除して有効に戻す。」
            $holiday->status       = 0;
            $holiday->delete();
        }

        // 祝日一覧画面に戻る
        return redirect("/manage/holiday");
    }

    /**
     *  祝日設定削除
     */
    public function delete($request, $id)
    {
        // httpメソッド確認
        if (!$request->isMethod('post')) {
            abort(403, '権限がありません。');
        }

        // 削除
        $holiday = Holiday::where('id', $id)->delete();

        // 祝日一覧画面に戻る
        return redirect("/manage/holiday");
    }
}
