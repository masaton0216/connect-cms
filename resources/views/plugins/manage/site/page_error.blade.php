{{--
 * ページエラー設定のメインテンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category サイト管理
 --}}
{{-- 管理画面ベース画面 --}}
@extends('plugins.manage.manage')

{{-- 管理画面メイン部分のコンテンツ section:manage_content で作ること --}}
@section('manage_content')

<div class="card">
<div class="card-header p-0">

{{-- 機能選択タブ --}}
@include('plugins.manage.site.site_manage_tab')

</div>
<div class="card-body">

    <form action="{{url('/')}}/manage/site/savePageError" method="POST">
    {{csrf_field()}}

        {{-- 403 --}}
        <div class="form-group">
            <label class="col-form-label">IPアドレス制限などで権限がない場合の表示ページ</label>
            <input type="text" name="page_permanent_link_403" value="{{ Configs::getConfigsValueAndOld($configs, 'page_permanent_link_403', null) }}" class="form-control">
        </div>

        {{-- 404 --}}
        <div class="form-group">
            <label class="col-form-label">指定ページがない場合の表示ページ</label>
            <input type="text" name="page_permanent_link_404" value="{{ Configs::getConfigsValueAndOld($configs, 'page_permanent_link_404', null) }}" class="form-control">
        </div>

        <div class="card card-body bg-light p-2 mb-3">
            <ul>
                <li>エラー設定の対象は一般画面です。管理画面は対象外です。</li>
            </ul>
        </div>

        {{-- Submitボタン --}}
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary form-horizontal"><i class="fas fa-check"></i> 更新</button>
        </div>
    </form>
</div>
</div>

@endsection
