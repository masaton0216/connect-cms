{{--
 * 掲示板の記事のタイトル行テンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category 掲示板プラグイン
--}}
@if ($plugin_frame->list_underline)
<div class="border-bottom clearfix {{$list_class}}">
@else
<div class="clearfix {{$list_class}}">
@endif
    <div class="float-left">
        <i class="fas fa-chevron-circle-right"></i>
        @include('plugins.user.bbses.default.post_title', ['view_post' => $view_post, 'current_post' => $current_post])
    </div>
    <div class="float-right">{{$view_post->created_at->format('Y-m-d')}} [{{$view_post->created_name}}]</div>
</div>
