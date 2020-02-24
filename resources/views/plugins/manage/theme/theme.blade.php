{{--
 * テーマ管理のメインテンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category テーマ管理
 --}}
{{-- 管理画面ベース画面 --}}
@extends('plugins.manage.manage')

{{-- 管理画面メイン部分のコンテンツ section:manage_content で作ること --}}
@section('manage_content')

<div class="card mb-3">
    <div class="card-header p-0">
        {{-- 機能選択タブ --}}
        @include('plugins.manage.theme.theme_manage_tab')
    </div>
</div>

<form action="{{url('/')}}/manage/theme/editCss" method="post" name="form_css" class="d-inline">
    {{ csrf_field() }}
    <input type="hidden" name="dir_name" value="">
</form>

<form action="{{url('/')}}/manage/theme/editName" method="post" name="form_name" class="d-inline">
    {{ csrf_field() }}
    <input type="hidden" name="dir_name" value="">
</form>

<script type="text/javascript">
    // CSS 編集画面へ
    function view_css_edit(dir_name)
    {
        form_css.dir_name.value = dir_name;
        form_css.submit();
    }
    // テーマ名編集画面へ
    function view_name_edit(dir_name)
    {
        form_name.dir_name.value = dir_name;
        form_name.submit();
    }
</script>

<ul class="list-group mb-3">
    <li class="list-group-item bg-light">ユーザ・テーマ一覧</li>
    @foreach($dirs as $dir)
        <li class="list-group-item">
            {{$dir}}　 <a href="javascript:view_css_edit('{{$dir}}');">［CSS編集］</a> <a href="javascript:view_name_edit('{{$dir}}');">［テーマ名編集］</a>
        </li>
    @endforeach
</ul>

<div class="card">
    <div class="card-header">
        新規作成
    </div>
    <div class="card-body">
        <form action="/manage/theme/create" method="POST">
            {{csrf_field()}}

            {{-- テーマ名 --}}
            <div class="form-group row">
                <label for="dir_name" class="col-md-3 col-form-label text-md-right">ディレクトリ名</label>
                <div class="col-md-9">
                    <input type="text" name="dir_name" id="dir_name" value="{{old('dir_name', '')}}" class="form-control">
                    @if ($errors && $errors->has('dir_name')) <div class="text-danger">{{$errors->first('dir_name')}}</div> @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="theme_name" class="col-md-3 col-form-label text-md-right">テーマ名</label>
                <div class="col-md-9">
                    <input type="text" name="theme_name" id="theme_name" value="{{old('theme_name', '')}}" class="form-control">
                    @if ($errors && $errors->has('theme_name')) <div class="text-danger">{{$errors->first('theme_name')}}</div> @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-3 col-sm-6">
                    <button type="submit" class="btn btn-primary form-horizontal">
                        <i class="fas fa-check"></i> 新規作成
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection