{{--
 * 編集画面tabテンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category サイト管理
 --}}
<ul class="nav nav-tabs">
@if ($function == "index")
    <li class="nav-item"><a href="{{url('/manage/site')}}" class="nav-link active">サイト基本設定</a></li>
@else
    <li class="nav-item"><a href="{{url('/manage/site')}}" class="nav-link">サイト基本設定</a></li>
@endif
@if ($function == "categories")
    <li class="nav-item"><a href="{{url('/manage/site/categories')}}" class="nav-link active">カテゴリ設定</a></li>
@else
    <li class="nav-item"><a href="{{url('/manage/site/categories')}}" class="nav-link">カテゴリ設定</a></li>
@endif
@if ($function == "languages")
    <li class="nav-item"><a href="{{url('/manage/site/languages')}}" class="nav-link active">多言語設定</a></li>
@else
    <li class="nav-item"><a href="{{url('/manage/site/languages')}}" class="nav-link">多言語設定</a></li>
@endif
</ul>
