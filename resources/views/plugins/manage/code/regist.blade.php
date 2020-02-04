{{--
 * コード登録画面のテンプレート
 *
 * @author 牟田口 満 <mutaguchi@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category コード管理
 --}}
{{-- 管理画面ベース画面 --}}
@extends('plugins.manage.manage')

{{-- 管理画面メイン部分のコンテンツ section:manage_content で作ること --}}
@section('manage_content')

<div class="card">
<div class="card-header p-0">

{{-- 機能選択タブ --}}
@include('plugins.manage.code.code_manage_tab')

{{-- ボタンによってアクション切替 --}}
<script type="text/javascript">
    function submitAction(url) {
        form_code.action = url;
        form_code.submit();
    }
    function submitActionConfirm(url, message = '削除します。\nよろしいですか？') {
        if (confirm(message)) {
            form_code.action = url;
            form_code.submit();
        }
    }
</script>

</div>
<div class="card-body">

    <form name="form_code" action="" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Code form  -->
        <div class="form-group row">
        <label for="plugin_name" class="col-md-3 col-form-label text-md-right">plugin_name</label>
            <div class="col-md-9">
                <select name="plugin_name" id="plugin_name" class="form-control">
                    <option value=""@if($code->plugin_name == "") selected @endif>設定なし</option>
                    @foreach ($plugins as $plugin)
                        <option value="{{$plugin->plugin_name}}"@if($code->plugin_name == $plugin->plugin_name) selected @endif>{{$plugin->plugin_name_full}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="buckets_id" class="col-md-3 col-form-label text-md-right">buckets_id</label>
            <div class="col-md-9">
                <input type="text" name="buckets_id" id="buckets_id" value="{{$code->buckets_id}}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="prefix" class="col-md-3 col-form-label text-md-right">prefix</label>
            <div class="col-md-9">
                <input type="text" name="prefix" id="prefix" value="{{$code->prefix}}" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label for="type_name" class="col-md-3 col-form-label text-md-right">type_name</label>
            <div class="col-md-9">
                <input type="text" name="type_name" id="type_name" value="{{$code->type_name}}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="type_code1" class="col-md-3 col-form-label text-md-right">type_code1</label>
            <div class="col-md-9">
                <input type="text" name="type_code1" id="type_code1" value="{{$code->type_code1}}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="type_code2" class="col-md-3 col-form-label text-md-right">type_code2</label>
            <div class="col-md-9">
                <input type="text" name="type_code2" id="type_code2" value="{{$code->type_code2}}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="type_code3" class="col-md-3 col-form-label text-md-right">type_code3</label>
            <div class="col-md-9">
                <input type="text" name="type_code3" id="type_code3" value="{{$code->type_code3}}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="type_code4" class="col-md-3 col-form-label text-md-right">type_code4</label>
            <div class="col-md-9">
                <input type="text" name="type_code4" id="type_code4" value="{{$code->type_code4}}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="type_code5" class="col-md-3 col-form-label text-md-right">type_code5</label>
            <div class="col-md-9">
                <input type="text" name="type_code5" id="type_code5" value="{{$code->type_code5}}" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label for="code" class="col-md-3 col-form-label text-md-right">コード <label class="badge badge-danger">必須</label></label>
            <div class="col-md-9">
                <input type="text" name="code" id="code" value="{{$code->code}}" class="form-control">
                @if ($errors && $errors->has('code')) <div class="text-danger">{{$errors->first('code')}}</div> @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="value" class="col-md-3 col-form-label text-md-right">値 <label class="badge badge-danger">必須</label></label>
            <div class="col-md-9">
                <input type="text" name="value" id="value" value="{{$code->value}}" class="form-control">
                @if ($errors && $errors->has('value')) <div class="text-danger">{{$errors->first('value')}}</div> @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="display_sequence" class="col-md-3 col-form-label text-md-right">並び順</label>
            <div class="col-md-9">
                <input type="text" name="display_sequence" id="display_sequence" value="{{$code->display_sequence}}" class="form-control">
            </div>
        </div>

        <!-- Add or Update code Button -->
        <div class="form-group row">
            <div class="offset-sm-3 col-sm-6">
                <button type="button" class="btn btn-secondary mr-2" onclick="location.href='{{url('/manage/code')}}'"><i class="fas fa-times"></i> キャンセル</button>
                @if ($code->id)
                <button type="button" class="btn btn-primary form-horizontal mr-2" onclick="submitAction('{{url('/manage/code/update')}}/{{$code->id}}')">
                    <i class="fas fa-check"></i> 更新
                </button>
                <button type="button" class="btn btn-primary form-horizontal" onclick="submitAction('{{url('/manage/code/store')}}')">
                    <i class="fas fa-copy "></i> 別名登録
                </button>
                @else
                <button type="button" class="btn btn-primary form-horizontal mr-2" onclick="submitAction('{{url('/manage/code/store')}}')">
                    <i class="fas fa-check"></i> 登録
                </button>
                @endif
            </div>
            @if ($code->id)
            <div class="col-sm-3 pull-right text-right">
                <button type="button" class="btn btn-danger form-horizontal" onclick="submitActionConfirm('{{url('/manage/code/destroy')}}/{{$code->id}}')">
                    <i class="fas fa-trash-alt"></i> 削除
                </button>
            </div>
            @endif
        </div>
    </form>

</div>
</div>

@endsection
