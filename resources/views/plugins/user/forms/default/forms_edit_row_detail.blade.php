{{--
 * フォーム項目の詳細設定画面
 *
 * @author 井上 雅人 <inoue@opensource-workshop.jp / masamasamasato0216@gmail.com>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category フォーム・プラグイン
 --}}
 @extends('core.cms_frame_base_setting')

 @section("core.cms_frame_edit_tab_$frame->id")
      {{-- プラグイン側のフレームメニュー --}}
     @include('plugins.user.forms.forms_frame_edit_tab')
 @endsection
 
 @section("plugin_setting_$frame->id")
<script type="text/javascript">

    /**
     * 選択肢の追加ボタン押下
     */
    function submit_add_select(btn) {
        form_column_detail.action = "/plugin/forms/addSelect/{{$page->id}}/{{$frame_id}}#frame-{{$frame_id}}";
        btn.disabled = true;
        form_column_detail.submit();
    }

    /**
     * 選択肢の表示順操作ボタン押下
     */
    function submit_display_sequence(select_id, display_sequence, display_sequence_operation) {
        form_column_detail.action = "/plugin/forms/updateSelectSequence/{{$page->id}}/{{$frame_id}}#frame-{{$frame_id}}";
        form_column_detail.select_id.value = select_id;
        form_column_detail.display_sequence.value = display_sequence;
        form_column_detail.display_sequence_operation.value = display_sequence_operation;
        form_column_detail.submit();
    }

    /**
     * 選択肢の更新ボタン押下
     */
    function submit_update_select(select_id) {
        form_column_detail.action = "/plugin/forms/updateSelect/{{$page->id}}/{{$frame_id}}#frame-{{$frame_id}}";
        form_column_detail.select_id.value = select_id;
        form_column_detail.submit();
    }

    /**
     * 選択肢の削除ボタン押下
     */
     function submit_delete_select(select_id) {
        if(confirm('選択肢を削除します。\nよろしいですか？')){
            form_column_detail.action = "/plugin/forms/deleteSelect/{{$page->id}}/{{$frame_id}}#frame-{{$frame_id}}";
            form_column_detail.select_id.value = select_id;
            form_column_detail.submit();
        }
        return false;
    }
</script>

<form action="" id="form_column_detail" name="form_column_detail" method="POST" class="form-horizontal">

    {{ csrf_field() }}
    <input type="hidden" name="forms_id" value="{{ $forms_id }}">
    <input type="hidden" name="column_id" value="{{ $column->id }}">
    <input type="hidden" name="select_id" value="">
    <input type="hidden" name="display_sequence" value="">
    <input type="hidden" name="display_sequence_operation" value="">

    {{-- メッセージエリア --}}
    <div class="alert alert-info mt-2">
        <i class="fas fa-exclamation-circle"></i> {{ $message ? $message : '項目【' . $column->column_name . ' 】の選択肢を追加・変更します。' }}
    </div>
    
    <div class="table-responsive">

        {{-- 選択項目の一覧 --}}
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    @if (count($selects) > 0)
                        <th class="text-center" nowrap>表示順</th>
                        <th class="text-center" nowrap>選択肢名</th>
                        <th class="text-center" nowrap>更新</th>
                        <th class="text-center" nowrap>削除</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                {{-- 更新用の行 --}}
                @foreach($selects as $select)
                    <tr  @if (isset($select->hide_flag)) class="table-secondary" @endif>
                        {{-- 表示順操作 --}}
                        <td class="text-center" nowrap>
                            {{-- 上移動 --}}
                            <button type="button" class="btn btn-default btn-xs p-1" @if ($loop->first) disabled @endif onclick="javascript:submit_display_sequence({{ $select->id }}, {{ $select->display_sequence }}, 'up')">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                    
                            {{-- 下移動 --}}
                            <button type="button" class="btn btn-default btn-xs p-1" @if ($loop->last) disabled @endif onclick="javascript:submit_display_sequence({{ $select->id }}, {{ $select->display_sequence }}, 'down')">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </td>

                        {{-- 選択肢名 --}}
                        <td>
                            <input class="form-control" type="text" name="select_name_{{ $select->id }}" value="{{ old('select_name_'.$select->id, $select->value)}}">
                        </td>

                        {{-- 更新ボタン --}}
                        <td class="align-middle text-center">
                            <button 
                                class="btn btn-primary cc-font-90 text-nowrap" 
                                onclick="javascript:submit_update_select({{ $select->id }});"
                            >
                                <i class="fas fa-save"></i> <span class="d-sm-none">更新</span>
                            </button>
                        </td>
                        {{-- 削除ボタン --}}
                        <td class="text-center">
                                <button 
                                class="btn btn-danger cc-font-90 text-nowrap" 
                                onclick="javascript:return submit_delete_select({{ $select->id }});"
                            >
                                <i class="fas fa-trash-alt"></i> <span class="d-sm-none">削除</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tr class="thead-light">
                    <th colspan="7">【選択肢の追加行】</th>
                </tr>

                {{-- 新規登録用の行 --}}
                <tr>
                    <td>
                        {{-- 余白 --}}
                    </td>
                    <td>
                        {{-- 選択肢名 --}}
                        <input class="form-control" type="text" name="select_name" value="{{ old('select_name') }}" placeholder="選択肢名">
                    </td>
                    <td class="text-center">
                        {{-- ＋ボタン --}}
                        <button class="btn btn-primary cc-font-90 text-nowrap" onclick="javascript:submit_add_select(this);"><i class="fas fa-plus"></i> <span class="d-sm-none">追加</span></button>
                    </td>
                    <td>
                        {{-- 余白 --}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- エラーメッセージエリア --}}
    @if ($errors && $errors->any())
        <div class="alert alert-danger mt-2">
            @foreach ($errors->all() as $error)
            <i class="fas fa-exclamation-circle"></i>
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    {{-- ボタンエリア --}}
    <div class="form-group text-center">
        {{-- キャンセルボタン --}}
        <button type="button" class="btn btn-secondary mr-2" onclick="location.href='{{url('/')}}/plugin/forms/editColumn/{{$page->id}}/{{$frame_id}}/#frame-{{$frame->id}}'"><i class="fas fa-times"></i> キャンセル</button>
    </div>
</form>
@endsection