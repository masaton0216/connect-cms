{{--
 * メニューの子要素表示画面
 *
 * @param obj $pages ページデータの配列
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category メニュープラグイン
--}}

@if ($children->isView(Auth::user()))
<li>
    @if ($children->id == $page_id)
    <a class="dropdown-item active" href="{{$children->getUrl()}}" {!!$children->getUrlTargetTag()!!}>
    @else
    <a class="dropdown-item" href="{{$children->getUrl()}}" {!!$children->getUrlTargetTag()!!}>
    @endif

        {{-- 各ページの深さをもとにインデントの表現 --}}
        {{-- @for ($i = 0; $i < $children->depth; $i++)
            @if ($i+1==$children->depth && $menu) {!!$menu->getIndentFont()!!} @else <span class="px-2"></span>@endif
        @endfor --}}
        {{$children->page_name}}
    </a>
    @if ($children->children && count($children->children) > 0)
        <ul>
            @foreach($children->children as $ckey => $depth_children)
                @include('plugins.user.menus.mouseover_dropdown_no_rootlink_for_design.menu_children',['children' => $children->children[$ckey]])
            @endforeach
        </ul>
    @endif
</li>
@endif