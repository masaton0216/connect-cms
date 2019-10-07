{{--
 * 編集画面tabテンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category OPACプラグイン
 --}}
@if ($action == 'editBuckets')
    <li role="presentation" class="nav-item"><a href="{{url('/')}}/plugin/opacs/editBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link active">OPAC設定変更</a></li>
@else
    <li role="presentation" class="nav-item"><a href="{{url('/')}}/plugin/opacs/editBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link">OPAC設定変更</a></li>
@endif
@if ($action == 'createBuckets')
    <li role="presentation" class="nav-item"><a href="{{url('/')}}/plugin/opacs/createBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link active">OPAC新規作成</a></li>
@else
    <li role="presentation" class="nav-item"><a href="{{url('/')}}/plugin/opacs/createBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link">OPAC新規作成</a></li>
@endif
@if ($action == 'listBuckets')
    <li role="presentation" class="nav-item"><a href="{{url('/')}}/plugin/opacs/listBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link active">表示OPAC選択</a></li>
@else
    <li role="presentation" class="nav-item"><a href="{{url('/')}}/plugin/opacs/listBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link">表示OPAC選択</a></li>
@endif
