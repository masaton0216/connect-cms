<?php

namespace App\Plugins\Manage\ServiceManage;

use Illuminate\Support\Facades\Validator;

use App\Models\Core\Configs;

use App\Plugins\Manage\ManagePluginBase;

use App\Enums\AuthMethodType;

/**
 * 外部サービス設定クラス
 *
 * @author 牟田口 満 <mutaguchi@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category 外部サービス設定
 * @package Controller
 */
class ServiceManage extends ManagePluginBase
{
    /**
     * 権限定義
     */
    public function declareRole()
    {
        // 権限チェックテーブル
        $role_check_table = [];
        $role_check_table["index"] = ['admin_site'];
        $role_check_table["update"] = ['admin_site'];
        $role_check_table["pdf"] = ['admin_site'];
        $role_check_table["pdfUpdate"] = ['admin_site'];

        return $role_check_table;
    }

    /**
     * 初期表示（WYSIWYG設定）
     *
     * @return view
     */
    public function index($request, $id = null, $sub_id = null)
    {
        // Config データの取得
        $configs = Configs::where('category', 'service')->get();

        return view('plugins.manage.service.index', [
            "function" => __FUNCTION__,
            "plugin_name" => "service",
            "configs" => $configs,
            "pdf_api_disabled_label" => !config('connect.PDF_THUMBNAIL_API_URL') ? 'disabled' : '',
        ]);
    }

    /**
     * WYSIWYG設定 更新処理
     */
    public function update($request, $id = null)
    {
        // PDFアップロードを使用
        $configs = Configs::updateOrCreate(
            ['name' => 'use_pdf_thumbnail'],
            ['category' => 'service', 'value' => $request->use_pdf_thumbnail]
        );

        // 画面に戻る
        return redirect("/manage/service")->with('flash_message', '更新しました。');
    }

    /**
     * PDFアップロード設定 表示
     *
     * @return view
     */
    public function pdf($request, $id = null, $sub_id = null)
    {
        // Config データの取得
        $configs = Configs::where('category', 'service')->get();

        return view('plugins.manage.service.pdf', [
            "function" => __FUNCTION__,
            "plugin_name" => "service",
            "configs" => $configs,
            "pdf_api_disabled_label" => !config('connect.PDF_THUMBNAIL_API_URL') ? 'disabled' : '',
        ]);
    }

    /**
     * PDFアップロード設定の保存
     */
    public function pdfUpdate($request, $id = null)
    {
        // httpメソッド確認
        if (!$request->isMethod('post')) {
            abort(403, '権限がありません。');
        }

        // 初期に選択させるサムネイルの大きさ
        $configs = Configs::updateOrCreate(
            ['name' => 'width_of_pdf_thumbnails_initial'],
            ['category' => 'service', 'value' => $request->width_of_pdf_thumbnails_initial]
        );

        // 初期に選択させるサムネイルの数
        $configs = Configs::updateOrCreate(
            ['name' => 'number_of_pdf_thumbnails_initial'],
            ['category' => 'service', 'value' => $request->number_of_pdf_thumbnails_initial]
        );

        // サムネイルのリンク
        $configs = Configs::updateOrCreate(
            ['name' => 'link_of_pdf_thumbnails'],
            ['category' => 'service', 'value' => $request->link_of_pdf_thumbnails]
        );

        // 画面に戻る
        return redirect("/manage/service/pdf")->with('flash_message', '更新しました。');
    }
}