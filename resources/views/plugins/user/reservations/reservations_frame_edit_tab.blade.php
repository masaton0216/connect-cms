{{--
 * 編集画面tabテンプレート
 *
 * @author 井上 雅人 <inoue@opensource-workshop.jp / masamasamasato0216@gmail.com>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category 施設予約プラグイン
--}}
<li role="presentation" class="nav-item">
    <a href="{{url('/')}}/plugin/reservations/editFacilities/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="nav-link {{ $action == 'editFacilities' ? 'active' : '' }}">施設設定</a>
</li>
<li role="presentation" class="nav-item">
    <a href="{{url('/')}}/plugin/reservations/editColumn/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="nav-link {{ $action == 'editColumn' ? 'active' : '' }}">項目設定</a>
</li>

@if ($action == 'editColumnDetail')
    <li role="presentation" class="nav-item">
        <span class="nav-link"><span class="active">項目詳細設定</span></span>
    </li>
@endif

<li role="presentation" class="nav-item">
    <a href="{{url('/')}}/plugin/reservations/editBuckets/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="nav-link {{ $action == 'editBuckets' ? 'active' : '' }}">設定変更</a>
</li>
<li role="presentation" class="nav-item">
    <a href="{{url('/')}}/plugin/reservations/createBuckets/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="nav-link {{ $action == 'createBuckets' ? 'active' : '' }}">新規作成</a>
</li>
<li role="presentation" class="nav-item">
    <a href="{{url('/')}}/plugin/reservations/listBuckets/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="nav-link {{ $action == 'listBuckets' ? 'active' : '' }}">施設予約選択</a>
</li>

<li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        その他設定
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

        @if ($action == "editBucketsRoles")
            <a href="{{url('/')}}/plugin/reservations/editBucketsRoles/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="dropdown-item active bg-light">権限設定</a>
        @else
            <a href="{{url('/')}}/plugin/reservations/editBucketsRoles/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="dropdown-item">権限設定</a>
        @endif

        @if ($action == "editBucketsMails")
            <a href="{{url('/')}}/plugin/{{$frame->plugin_name}}/editBucketsMails/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="dropdown-item active bg-light">メール設定</a>
        @else
            <a href="{{url('/')}}/plugin/{{$frame->plugin_name}}/editBucketsMails/{{$page->id}}/{{$frame->id}}#frame-{{$frame->id}}" class="dropdown-item">メール設定</a>
        @endif

    </div>
</li>
