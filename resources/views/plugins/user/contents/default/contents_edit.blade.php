{{--
 * 編集画面テンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category コンテンツプラグイン
--}}
@extends('core.cms_frame_base')

@section("plugin_contents_$frame->id")
{{-- WYSIWYG 呼び出し --}}
@include('plugins.common.wysiwyg', ['target_class' => 'wysiwyg' . $frame->id])

{{-- 一時保存ボタンのアクション --}}
<script type="text/javascript">
    function save_action() {
        @if (empty($contents->id))
            form_update.action = "{{url('/')}}/redirect/plugin/contents/temporarysave/{{$page->id}}/{{$frame_id}}#frame-{{$frame->id}}";
        @else
            form_update.action = "{{url('/')}}/redirect/plugin/contents/temporarysave/{{$page->id}}/{{$frame_id}}/{{$contents->id}}#frame-{{$frame->id}}";
        @endif
        form_update.submit();
    }
</script>

@if (empty($contents->id))
    {{-- 新規登録用フォーム --}}
    <form action="{{url('/')}}/redirect/plugin/contents/store/{{$page->id}}/{{$frame_id}}#frame-{{$frame->id}}" method="POST" name="form_update" id="{{$frame->plugin_name}}-{{$frame->id}}-form">
        <input type="hidden" name="redirect_path" value="{{url('/')}}/plugin/contents/edit/{{$page->id}}/{{$frame_id}}#frame-{{$frame->id}}">
@else
    {{-- 更新用フォーム --}}
    <form action="{{url('/')}}/redirect/plugin/contents/update/{{$page->id}}/{{$frame_id}}/{{$contents->id}}#frame-{{$frame->id}}" method="POST" name="form_update" id="{{$frame->plugin_name}}-{{$frame->id}}-form">
        <input type="hidden" name="redirect_path" value="{{url('/')}}/plugin/contents/edit/{{$page->id}}/{{$frame_id}}/{{$contents->id}}#frame-{{$frame->id}}">
@endif

    {{ csrf_field() }}
    <input type="hidden" name="action" value="edit">

    <div class="form-group">
        <div @if ($errors && $errors->has('contents')) class="border border-danger" @endif>
            <textarea name="contents" class="wysiwyg{{$frame->id}}">{!! old('contents', $contents->content_text) !!}</textarea>
        </div>
        @include('plugins.common.errors_inline_wysiwyg', ['name' => 'contents'])
    </div>

    <div class="form-group">
        <label class="control-label">データ名</label>
        <input type="text" name="bucket_name" value="{{old('bucket_name', $contents->bucket_name)}}" class="form-control @if ($errors && $errors->has('bucket_name')) border-danger @endif">
        @include('plugins.common.errors_inline', ['name' => 'bucket_name'])
        <small class="text-muted">※ 空の場合「無題」で登録します。</small>
    </div>

    @if ($contents->status == 1)
        <span class="badge badge-warning align-bottom float-left mt-1">一時保存</span>
    @endif

    @if ($contents->status == 2)
        @can('role_update_or_approval',[[$contents, 'contents', $buckets]])
            <span class="badge badge-warning align-bottom float-left mt-1">承認待ち</span>
        @endcan
    @endif

    <div class="form-group text-center">
        <input type="hidden" name="bucket_id" value="{{$contents->bucket_id}}">
        <br />
        <button type="button" class="btn btn-secondary mr-2" onclick="location.href='{{URL::to($page->permanent_link)}}#frame-{{$frame->id}}'"><i class="fas fa-times"></i><span class="{{$frame->getSettingButtonCaptionClass()}}"> キャンセル</span></button>
        <button type="button" class="btn btn-info mr-2" onclick="save_action();"><i class="far fa-save"></i><span class="{{$frame->getSettingButtonCaptionClass()}}"> 一時保存</span></button>
        @if (empty($contents->id))
            @if ($buckets && $buckets->needApprovalUser(Auth::user(), $frame))
                <button type="submit" class="btn btn-success"><i class="far fa-edit"></i> 登録申請</button>
            @else
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> 登録確定</button>
            @endif
        @else
            @if ($buckets && $buckets->needApprovalUser(Auth::user(), $frame))
                <button type="submit" class="btn btn-success"><i class="far fa-edit"></i> 変更申請</button>
            @else
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> 変更確定</button>
            @endif
        @endif
    </div>
</form>
@endsection
