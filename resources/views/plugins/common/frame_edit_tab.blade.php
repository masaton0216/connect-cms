{{--
 * 編集画面tabテンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category フォームプラグイン
 --}}
@yield('content_frame_edit_tab')
@if ($action == 'datalist')
    <li role="presentation" class="nav-item"><a href="{{url('/')}}/plugin/{{$frame->plugin_name}}/datalist/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link active">{{$frame->plugin_name_full}}選択</a></li>
@else
    <li role="presentation" class="nav-item"><a href="{{url('/')}}/plugin/{{$frame->plugin_name}}/datalist/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link">{{$frame->plugin_name_full}}選択</a></li>
@endif
