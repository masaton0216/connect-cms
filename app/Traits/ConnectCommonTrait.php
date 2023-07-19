<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

//use Carbon\Carbon;

use App\Models\Common\ConnectCarbon;
use App\Models\Common\Frame;
use App\Models\Common\Holiday;
use App\Models\Common\Page;
use App\Models\Common\YasumiHoliday;
use App\Models\Core\Plugins;

trait ConnectCommonTrait
{
    /**
     * 権限チェック ＆ エラー時
     * roll_or_auth : 権限 or 役割
     *
     * @return view|null 権限チェックの結果、エラーがあればエラー表示用HTML が返ってくる。
     *
     * @see \App\Providers\AppServiceProvider AppServiceProvider::boot()
     */
    public function can($roll_or_auth, $post = null, $plugin_name = null, $buckets = null, $frame = null)
    {
        $args = null;
        if ($post != null || $plugin_name != null || $buckets != null || $frame != null) {
            $args = [[$post, $plugin_name, $buckets, $frame]];
        }

        if (!Auth::check() || !Auth::user()->can($roll_or_auth, $args)) {
            return $this->viewError("403_inframe", null, "canメソッドチェック:{$roll_or_auth}");
        }
    }

    /**
     * 権限チェック
     * roll_or_auth : 権限 or 役割
     *
     * @return bool
     *
     * @see \App\Providers\AppServiceProvider AppServiceProvider::boot()
     */
    public function isCan($roll_or_auth, $post = null, $plugin_name = null, $buckets = null, $frame = null): bool
    {
        $args = null;
        if ($post != null || $plugin_name != null || $buckets != null || $frame != null) {
            $args = [[$post, $plugin_name, $buckets, $frame]];
        }

        if (!Auth::check() || !Auth::user()->can($roll_or_auth, $args)) {
            return false;
        }
        return true;
    }

    /**
     * エラー画面の表示
     */
    public function viewError($error_code, $message = null, $debug_message = null)
    {
        // 表示テンプレートを呼び出す。
        return view('errors.' . $error_code, ['message' => $message, 'debug_message' => $debug_message]);
    }

    /**
     * プラグイン一覧の取得
     */
    public function getPlugins($arg_display_flag = true, $force_get = false)
    {
        // プラグイン一覧の取得
        $display_flag = ($arg_display_flag) ? 1 : 0;
        $plugins = Plugins::where('display_flag', $display_flag)->orderBy('display_sequence')->get();

        // 強制的に非表示にするプラグインを除外
        if (!$force_get) {
            foreach ($plugins as $plugin_loop_key => $plugin) {
                if (in_array(mb_strtolower($plugin->plugin_name), config('connect.PLUGIN_FORCE_HIDDEN'))) {
                    $plugins->forget($plugin_loop_key);
                }
            }
        }
        return $plugins;
    }

    /**
     * 曜日取得
     *
     * @todo app\Plugins\User\Openingcalendars\OpeningcalendarsPlugin.php のみで使われている。今後移動予定
     */
    public function getWeekJp($date)
    {
        switch (date('N', strtotime($date))) {
            case 1:
                return "月";
            break;
            case 2:
                return "火";
            break;
            case 3:
                return "水";
            break;
            case 4:
                return "木";
            break;
            case 5:
                return "金";
            break;
            case 6:
                return "土";
            break;
            case 7:
                return "日";
            break;
        }
    }

    /**
     * IPアドレスが範囲内か
     */
    private function isRangeIp($remote_ip, $check_ips)
    {
        // * は範囲内
        if ($check_ips == "*") {
            return true;
        }

        // IP アドレス直接チェック
        if (strpos($check_ips, '/') === false) {
            return ($remote_ip === $check_ips);
        }

        // CIDR 形式
        list($check_ip, $mask) = explode('/', $check_ips);
        $check_ip_long  = ip2long($check_ip)  >> (32 - $mask);
        $remote_ip_long = ip2long($remote_ip) >> (32 - $mask);

        return ($check_ip_long == $remote_ip_long);
    }

    /**
     * 特別なパスか判定
     */
    public function isSpecialPath($path)
    {
        // 一般画面の特別なパス
        if (array_key_exists($path, config('connect.CC_SPECIAL_PATH'))) {
            return 1;
        }
        // 管理画面の特別なパス
        if (array_key_exists($path, config('connect.CC_SPECIAL_PATH_MANAGE'))) {
            return 2;
        }
        // マイページ画面の特別なパス
        if (array_key_exists($path, config('connect.CC_SPECIAL_PATH_MYPAGE'))) {
            return 3;
        }
        return false;
    }

    /**
     * 管理プラグインのインスタンス生成
     *
     * @param String $plugin_name
     * @return obj 生成したインスタンス
     */
    private static function createManageInstance($plugin_name)
    {
        // プラグイン毎に動的にnew するので、use せずにここでrequire する。
        $file_path = base_path() . "/app/Plugins/Manage/" . ucfirst($plugin_name) . "Manage/" . ucfirst($plugin_name) . "Manage.php";

        /// インスタンスを生成して返す。
        $class_name = "app\Plugins\Manage\\" . ucfirst($plugin_name) . "Manage\\" . ucfirst($plugin_name) . "Manage";

        // テンプレート・ディレクトリがない場合はオプションプラグインのテンプレートディレクトリを探す
        if (!file_exists($file_path)) {
            $file_path = base_path() . "/app/PluginsOption/Manage/" . ucfirst($plugin_name) . "Manage/" . ucfirst($plugin_name) . "Manage.php";

            $class_name = "app\PluginsOption\Manage\\" . ucfirst($plugin_name) . "Manage\\" . ucfirst($plugin_name) . "Manage";

            // ファイルの存在確認
            if (!file_exists($file_path)) {
                abort(404);
            }
        }

        // 指定されたプラグインファイルの読み込み
        require $file_path;

        $plugin_instance = new $class_name;
        return $plugin_instance;
    }

    /**
     * マイページ用プラグインのインスタンス生成
     *
     * @param String $plugin_name
     * @return obj 生成したインスタンス
     */
    private static function createMypageInstance($plugin_name)
    {
        // プラグイン毎に動的にnew するので、use せずにここでrequire する。
        $file_path = base_path() . "/app/Plugins/Mypage/" . ucfirst($plugin_name) . "Mypage/" . ucfirst($plugin_name) . "Mypage.php";

        // ファイルの存在確認
        if (!file_exists($file_path)) {
            abort(404);
        }

        // 指定されたプラグインファイルの読み込み
        require $file_path;

        /// インスタンスを生成して返す。
        $class_name = "app\Plugins\Mypage\\" . ucfirst($plugin_name) . "Mypage\\" . ucfirst($plugin_name) . "Mypage";
        $plugin_instance = new $class_name;
        return $plugin_instance;
    }

    /**
     * 管理プラグインの呼び出し
     *
     * @param String $plugin_name
     * @return プラグインからの戻り値(HTMLなど)
     */
    private function invokeManage($request, $plugin_name, $action = 'index', $id = null, $sub_id = null)
    {
        // ログインしているユーザー情報を取得
        $user = Auth::user();

        // 権限エラー
        if (empty($user)) {
            abort(403, 'ログインが必要です。');
        }

        // インスタンス生成
        $plugin_instance = self::createManageInstance($plugin_name);

        // 権限定義メソッドの有無確認
        if (!method_exists($plugin_instance, 'declareRole')) {
            abort(403, '権限定義メソッド(declareRole)がありません。');
        }

        // 権限チェック（管理系各プラグインの関数＆権限チェックデータ取得）
        $role_check = false;
        $role_ckeck_tables = $plugin_instance->declareRole();
        if (array_key_exists($action, $role_ckeck_tables)) {
            foreach ($role_ckeck_tables[$action] as $role) {
                // プラグインで定義された権限が自分にあるかチェック
                if ($this->isCan($role)) {
                    $role_check = true;
                }
            }
        } else {
            abort(403, 'メソッドに権限が設定されていません。');
        }

        if (!$role_check) {
            abort(403, 'ユーザーにメソッドに対する権限がありません。');
        }

//        // 操作ログの処理
//        $this->putAppLog($request, $this->getConfigs(), 'page');

        // 指定されたアクションを呼ぶ。
        // 呼び出し先のアクションでは、view 関数でblade を呼び出している想定。
        // view 関数の戻り値はHTML なので、ここではそのままreturn して呼び出し元に返す。
        return $plugin_instance->$action($request, $id, $sub_id);
    }

    /**
     * マイページ用プラグインの呼び出し
     *
     * @param String $plugin_name
     * @return プラグインからの戻り値(HTMLなど)
     */
    private function invokeMypage($request, $plugin_name, $action = 'index', $id = null, $sub_id = null)
    {
        // $action = 'index' が効かないため、改めてチェック
        if (empty($action)) {
            $action = 'index';
        }

        // ログインしているユーザー情報を取得
        $user = Auth::user();

        // 権限エラー
        if (empty($user)) {
            abort(403, 'ログインが必要です。');
        }

        // インスタンス生成
        $plugin_instance = self::createMypageInstance($plugin_name);

        // 指定されたアクションを呼ぶ。
        // 呼び出し先のアクションでは、view 関数でblade を呼び出している想定。
        // view 関数の戻り値はHTML なので、ここではそのままreturn して呼び出し元に返す。
        return $plugin_instance->$action($request, $id, $sub_id);
    }

    /**
     * 指定したパスの呼び出し
     */
    public function callSpecialPath($path, $request)
    {
        // インスタンスを生成して呼び出す。
        if ($this->isSpecialPath($path) === 1) {
            $cc_special_path = config('connect.CC_SPECIAL_PATH');
        } elseif ($this->isSpecialPath($path) === 2) {
            $cc_special_path = config('connect.CC_SPECIAL_PATH_MANAGE');
        } elseif ($this->isSpecialPath($path) === 3) {
            $cc_special_path = config('connect.CC_SPECIAL_PATH_MYPAGE');
        }

        $file_path = base_path() . '/' . $cc_special_path[$path]['plugin'] . '.php';

        // 一般プラグインの場合は、ここでインスタンスを生成
        // 一般プラグインの場合、通常はコアでフレーム分、インスタンスを生成してからinvokeするが、SpecialPathの場合はここでインスタンス生成する。
        // 管理プラグインの場合は、この後で呼ぶinvokeManageでインスタンス生成する。
        if ($this->isSpecialPath($path) === 1) {
            // Page とFrame の生成
            $page = Page::where('id', $cc_special_path[$path]['page_id'])->first();
            $frame = Frame::where('id', $cc_special_path[$path]['frame_id'])->first();

            // 指定されたプラグインファイルの読み込み
            require $file_path;

            // config の値を取得すると、\ が / に置き換えられているので、元に戻す。
            // こうしないとclass がないというエラーになる。
            $class_name = str_replace('/', "\\", $cc_special_path[$path]['plugin']);
            $plugin_instance = new $class_name($page, $frame);
        }

        // 一般プラグインか管理プラグインかで呼び方を変える。
        if ($this->isSpecialPath($path) === 1) {
            return $plugin_instance->invoke($plugin_instance, $request, $cc_special_path[$path]['method'], $cc_special_path[$path]['page_id'], $cc_special_path[$path]['frame_id']);
        } elseif ($this->isSpecialPath($path) === 2) {
            return $this->invokeManage($request, $cc_special_path[$path]['method']);
        } elseif ($this->isSpecialPath($path) === 3) {
            return $this->invokeMypage($request, $cc_special_path[$path]['method']);
        }
        return;
    }

    /**
     * CSRF用トークンの取得
     */
    public function getToken($arg)
    {
        if ($arg == 'hidden') {
            return '<input type="hidden" name="_token" value="' . Session::get('_token') . '">';
        }

        return Session::get('_token');
    }

    /**
     * ページの言語の取得
     */
    public function getPageLanguage($page, $languages)
    {
        // ページの言語
        $page_language = null;

        // 今、表示しているページの言語を判定
        $page_paths = explode('/', $page['permanent_link']);
        if ($page_paths && is_array($page_paths) && array_key_exists(1, $page_paths)) {
            foreach ($languages as $language) {
                if (trim($language->additional1, '/') == $page_paths[1]) {
                    $page_language = $page_paths[1];
                    break;
                }
            }
        }
        return $page_language;
    }

    /**
     * 対象ディレクトリの取得
     * uploads/1 のような形で返す。
     */
    public function getDirectory($file_id)
    {
        // ファイルID がなければ0ディレクトリを返す。
        if (empty($file_id)) {
            return config('connect.directory_base') . '0';
        }
        // 1000で割った余りがディレクトリ名
        $quotient = floor($file_id / config('connect.directory_file_limit'));
        $remainder = $file_id % config('connect.directory_file_limit');
        $sub_directory = ($remainder == 0) ? $quotient : $quotient + 1;
        $directory = config('connect.directory_base') . $sub_directory;

        return $directory;
    }

    /**
     * URLからページIDを取得
     */
    public function getPage($permanent_link, $language = null)
    {
        // 多言語指定されたとき
        if (!empty($language)) {
            $page = Page::where('permanent_link', '/' . $language . $permanent_link)->first();
            if (!empty($page)) {
                return $page;
            }
        }
        // 多言語指定されていない or 多言語側にページがない場合は全体から探す。

        // ページ確認
        return Page::where('permanent_link', $permanent_link)->first();
    }

    /**
     * URLから管理画面かどうかを判定
     */
    public function isManagePage($request)
    {
        $url_parts = explode('/', $request->path());
        if ($url_parts[0] == 'manage') {
            return true;
        }
        return false;
    }

    /**
     * page 変数がページオブジェクトか判定
     */
    public function isPageObj($page)
    {
        if (empty($page)) {
            return false;
        }
        if (get_class($page) == 'App\Models\Common\Page') {
            return true;
        }
        return false;
    }

    /**
     * 都道府県のリストの取得
     */
    public function getPrefList()
    {
        return array('北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県',
                     '茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県',
                     '新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県',
                     '三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県',
                     '鳥取県','島根県','岡山県','広島県','山口県',
                     '徳島県','香川県','愛媛県','高知県',
                     '福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県');
    }

    /**
     * カレンダー月表示データの生成
     */
    protected function generateCalendarMonthDates(ConnectCarbon $carbon_target_date) : array
    {
        $dates = [];

        $firstDay = new ConnectCarbon("$carbon_target_date->year-$carbon_target_date->month-01");
        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $firstDay->subDay($firstDay->dayOfWeek);
        // 35マス（7列×5行）で収まらない場合の加算日数の算出
        $addDay =
            // 当月の日数が31日、且つ、前の月末日が木曜か金曜の場合
            $carbon_target_date->copy()->endOfmonth()->day == 31 && ($firstDay->copy()->endOfmonth()->isThursday() || $firstDay->copy()->endOfmonth()->isFriday()) ||
            // 当月の日数が30日、且つ、前の月末日が金曜の場合
            $carbon_target_date->copy()->endOfmonth()->day == 30 && ($firstDay->copy()->endOfmonth()->isFriday())
            ? 7 : 0;
        // 当月の月末日以降の処理
        $count = 31 + $addDay;
        $count =  ceil($count / 7) * 7;
        // dd("addDay：$addDay","カレンダー1日目：$firstDay","カレンダー1日目の曜日：$firstDay->dayOfWeek","count:$count");

        for ($i = 0; $i < $count; $i++, $firstDay->addDay()) {
            $dates[$firstDay->format('Y-m-d')] = $firstDay->copy();
        }

        return $dates;
    }

    /**
     * 祝日の追加（From-To指定）
     *
     * date に holiday 属性を追加する。
     * 年またぎを考慮。
     */
    protected function addHolidaysFromTo(ConnectCarbon $start_date, ConnectCarbon $end_date, array $dates) : array
    {
        // 年の祝日一覧を取得する。
        $yasumis = YasumiHoliday::getYasumis($start_date->year);

        // 独自設定祝日データの取得（From-To指定）
        $connect_holidays = Holiday::whereBetween('holiday_date', [$start_date, $end_date])->orderBy('holiday_date')->get();

        // 独自設定祝日を加味する。
        $dates = $this->addConnectHolidays($connect_holidays, $dates, $yasumis);

        // 年またぎ対応（開始と終了で年が違う場合、終了年の祝日もセット）
        if ($start_date->year != $end_date->year) {
            $end_yasumis = YasumiHoliday::getYasumis($end_date->year);
            $dates = $this->addConnectHolidays($connect_holidays, $dates, $end_yasumis);
        }

        return $dates;
    }

    /**
     * 独自設定祝日を加味する。
     */
    private function addConnectHolidays(Collection $connect_holidays, array $dates, \Yasumi\Provider\AbstractProvider $yasumis) : array
    {
        // 独自設定祝日を加味する。
        $yasumis = YasumiHoliday::addConnectHolidays($connect_holidays, $yasumis);

        // 独自祝日を加味した祝日一覧をループ。対象の年月日があれば、date オブジェクトに holiday 属性として追加する。
        foreach ($yasumis as $yasumi) {
            if (isset($dates[$yasumi->format('Y-m-d')])) {
                $dates[$yasumi->format('Y-m-d')]->holiday = $yasumi;
            }
        }

        return $dates;
    }
}
