{{--
 * ログイン・バケツ編集画面テンプレート。
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category ログイン・プラグイン
--}}
@extends('core.cms_frame_base_setting')

@section("core.cms_frame_edit_tab_$frame->id")
    {{-- プラグイン側のフレームメニュー --}}
    @include('plugins.user.logins.logins_frame_edit_tab')
@endsection

@section("plugin_setting_$frame->id")

{{-- 共通エラーメッセージ 呼び出し --}}
@include('plugins.common.errors_form_line')

@if (empty($login->id) && $action != 'createBuckets')
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-circle"></i> {{ __('messages.empty_bucket_setting', ['plugin_name' => $frame->plugin_name_full]) }}
    </div>
@else
    <div class="alert alert-info">
        <i class="fas fa-exclamation-circle"></i>
        @if (empty($login->id))
            新しいログイン設定を登録します。
        @else
            ログイン設定を変更します。
        @endif
    </div>

    @if (empty($login->id))
    <form action="{{url('/')}}/redirect/plugin/logins/saveBuckets/{{$page->id}}/{{$frame_id}}#frame-{{$frame->id}}" method="POST" class="">
        <input type="hidden" name="redirect_path" value="{{url('/')}}/plugin/logins/createBuckets/{{$page->id}}/{{$frame_id}}#frame-{{$frame_id}}">
    @else
    <form action="{{url('/')}}/redirect/plugin/logins/saveBuckets/{{$page->id}}/{{$frame_id}}/{{$login->bucket_id}}#frame-{{$frame->id}}" method="POST" class="">
        <input type="hidden" name="redirect_path" value="{{url('/')}}/plugin/logins/editBuckets/{{$page->id}}/{{$frame_id}}#frame-{{$frame_id}}">
    @endif
        {{ csrf_field() }}
        <div class="form-group row">
            <label class="{{$frame->getSettingLabelClass()}}">ログイン名 <label class="badge badge-danger">必須</label></label>
            <div class="{{$frame->getSettingInputClass()}}">
                <input type="text" name="name" value="{{old('name', $login->name)}}" class="form-control">
                @if ($errors && $errors->has('name')) <div class="text-danger">{{$errors->first('name')}}</div> @endif
            </div>
        </div>

        {{-- 指定ページ --}}
        <div class="form-group row">
            <label class="{{$frame->getSettingLabelClass()}}">ログイン後に移動する指定ページ</label>
            <div class="{{$frame->getSettingInputClass()}}">
                <select name="redirect_page" class="form-control">
                    <option value=""></option>
                    @foreach($pages_select as $page_select)
                        <option value="{{$page_select->permanent_link}}" @if($login->redirect_page == $page_select->permanent_link) selected @endif>
                            @for ($i = 0; $i < $page_select->depth; $i++)
                            -
                            @endfor
                            {{$page_select->page_name}}
                        </option>
                    @endforeach
                </select>
                @include('plugins.common.errors_inline', ['name' => 'redirect_page'])
            </div>
        </div>

        {{-- Submitボタン --}}
        <div class="form-group text-center">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <button type="button" class="btn btn-secondary mr-2" onclick="location.href='{{URL::to($page->permanent_link)}}#frame-{{$frame->id}}'">
                        <i class="fas fa-times"></i><span class="{{$frame->getSettingButtonCaptionClass('md')}}"> キャンセル</span>
                    </button>
                    <button type="submit" class="btn btn-primary form-horizontal"><i class="fas fa-check"></i>
                        <span class="{{$frame->getSettingButtonCaptionClass()}}">
                        @if (empty($login->id))
                            登録確定
                        @else
                            変更確定
                        @endif
                        </span>
                    </button>
                </div>

                {{-- 既存ログインの場合は削除処理のボタンも表示 --}}
                @if (!empty($login->id))
                <div class="col-3 text-right">
                    <a data-toggle="collapse" href="#collapse{{$frame->id}}">
                        <span class="btn btn-danger"><i class="fas fa-trash-alt"></i><span class="{{$frame->getSettingButtonCaptionClass()}}"> 削除</span></span>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </form>

    <div id="collapse{{$frame->id}}" class="collapse">
        <div class="card border-danger">
            <div class="card-body">
                <span class="text-danger">ログインを削除します。<br>このログインに記載した記事も削除され、元に戻すことはできないため、よく確認して実行してください。</span>

                <div class="text-center">
                    {{-- 削除ボタン --}}
                    <form action="{{url('/')}}/redirect/plugin/logins/destroyBuckets/{{$page->id}}/{{$frame_id}}/{{$login->id}}#frame-{{$frame->id}}" method="POST">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-danger" onclick="javascript:return confirm('データを削除します。\nよろしいですか？')"><i class="fas fa-check"></i> 本当に削除する</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endif
@endsection
