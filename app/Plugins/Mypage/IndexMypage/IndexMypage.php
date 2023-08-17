<?php

namespace app\Plugins\Mypage\IndexMypage;

use Illuminate\Support\Facades\Auth;
use App\Models\Core\UsersInputCols;
use App\Plugins\Mypage\MypagePluginBase;
use App\Plugins\Manage\UserManage\UsersTool;

/**
 * マイページ画面インデックスクラス
 *
 * @plugin_title マイページ
 * @plugin_desc マイページの初めに開く画面です。自分の情報を確認できます。
 */
class IndexMypage extends MypagePluginBase
{
    public function getPublicFunctions()
    {
        // 標準関数以外で画面などから呼ばれる関数の定義
        $functions = [];
        $functions['get']  = [
            'passPdfDownload',
            'certPdfDownload',
        ];
        return $functions;
    }

    /**
     *  ページ初期表示
     *
     * @return view
     * @method_title マイページ
     * @method_desc ログインIDやメールアドレスを確認できます。
     * @method_detail
     */
    public function index($request)
    {
        // ログインしているユーザー情報を取得
        $user = Auth::user();
        $user_input_cols = UsersInputCols::select('users_input_cols.*', 'users_columns.column_type', 'users_columns.column_name', 'users_columns.display_sequence', 'uploads.client_original_name')
            ->leftJoin('users_columns', 'users_columns.id', '=', 'users_input_cols.users_columns_id')
            ->leftJoin('uploads', 'uploads.id', '=', 'users_input_cols.value')
            ->where('users_id', $user->id)
            ->orderBy('display_sequence', 'asc')
            ->orderBy('users_id', 'asc')
            ->orderBy('users_columns_id', 'asc')
            ->get();

        // ユーザーのカラム
        $users_columns = UsersTool::getUsersColumns($user->columns_set_id);

        // 管理画面プラグインの戻り値の返し方
        // view 関数の第一引数に画面ファイルのパス、第二引数に画面に渡したいデータを名前付き配列で渡し、その結果のHTML。
        return view('plugins.mypage.index.index', [
            'themes'          => $request->themes,
            "plugin_name"     => "index",
            "function"        => __FUNCTION__,
            "id"              => $user->id,
            "user"            => $user,
            "user_input_cols" => $user_input_cols,
            "users_columns"   => $users_columns,
        ]);
    }
}
