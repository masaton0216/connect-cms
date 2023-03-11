{{--
 * 任意のエラーメッセージのテンプレート。
 *
 * @author 牟田口 満 <mutaguchi@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category プラグイン共通
--}}
@extends('core.cms_frame_base')

@section("plugin_contents_$frame->id")
{{-- 利用者向けの業務メッセージ　表示期間外など --}}
@isset($error_messages)
<div class="card border-danger">
    <div class="card-body">
        @foreach ($error_messages as $error_message)
            <p class="text-center cc_margin_bottom_0">{!! nl2br(e($error_message)) !!}</p>
        @endforeach
    </div>
</div>
@endisset

{{-- 設定者向けのシステムメッセージ バケツ未設定など --}}
@isset($setting_error_messages)
@can('frames.edit',[[null, null, null, $frame]])
<div class="card border-danger">
    <div class="card-body">
        @foreach ($setting_error_messages as $error_message)
            <p class="text-center cc_margin_bottom_0">{!! nl2br(e($error_message)) !!}</p>
        @endforeach
    </div>
</div>
@endcan
@endisset

@endsection
