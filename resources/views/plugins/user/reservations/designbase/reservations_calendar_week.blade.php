{{--
 * 施設予約データ表示画面（週）
 *
 * @author 井上 雅人 <inoue@opensource-workshop.jp / masamasamasato0216@gmail.com>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category 施設予約プラグイン
--}}
<div class="row">
    <div class="col-12 clearfix">

        {{-- designbaseテンプレート --}}
        <div class="float-left week_nav">

            <div class="list-group list-group-horizontal">
                {{-- 前週ボタン --}}
                <a href="{{url('/')}}/plugin/reservations/week/{{$page->id}}/{{$frame->id}}/{{ $carbon_target_date->copy()->subDay(7)->format('Ymd') }}#frame-{{$frame->id}}" class="list-group-item btn btn-light d-flex align-items-center">
                    <i class="fas fa-angle-double-left"></i>
                </a>
                {{-- 当月表示 --}}
                <a class="list-group-item h5 d-flex align-items-center">
                    {{ App::getLocale() == ConnectLocale::ja ? $carbon_target_date->format('Y年n月') : $carbon_target_date->format('M Y') }}
                </a>
                {{-- 翌週ボタン --}}
                <a href="{{url('/')}}/plugin/reservations/week/{{$page->id}}/{{$frame->id}}/{{ $carbon_target_date->copy()->addDay(7)->format('Ymd') }}#frame-{{$frame->id}}" class="list-group-item btn btn-light d-flex align-items-center">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </div>
        </div>

        {{-- designbaseテンプレート --}}
        <div class="float-right col-sm-5 to_current">

            {{-- 当日へボタン --}}
            <a href="{{url('/')}}/plugin/reservations/week/{{$page->id}}/{{$frame->id}}/{{ Carbon::today()->format('Ymd') }}#frame-{{$frame->id}}" class="list-group-item btn btn-light rounded-pill">
                {{__('messages.to_today')}}<br>({{ App::getLocale() == ConnectLocale::ja ? Carbon::today()->format('Y年n月j日') : Carbon::today()->format('j M Y') }})
            </a>
        </div>
    </div>
</div>
<br>
{{-- 登録している施設分ループ --}}
@foreach ($calendars as $facility_name => $calendar_details)

    {{-- 施設名 --}}
    <span class="h5">＜{{ $facility_name }}＞</span>

    {{-- カレンダーデータ部 --}}
    <table class="table table-bordered cc_responsive_table" style="table-layout:fixed;">
        <thead>
            {{-- カレンダーヘッダ部の曜日を表示 --}}
            <tr>
                @foreach ($calendar_details['calendar_cells'] as $cell)
                    {{-- 日曜なら赤文字、土曜なら青文字 --}}
                    <th class="text-center bg-light{{ $cell['date']->dayOfWeek == DayOfWeek::sun ? ' text-danger' : '' }}{{ $cell['date']->dayOfWeek == DayOfWeek::sat ? ' text-primary' : '' }}">
                        {{ $cell['date']->day . '(' . DayOfWeek::getDescription($cell['date']->dayOfWeek) . ')' }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                {{-- カレンダーデータ部の表示 --}}
                @foreach ($calendar_details['calendar_cells'] as $cell)
                    <td class="
                        {{-- 日曜なら赤文字 --}}
                        {{ $cell['date']->dayOfWeek == DayOfWeek::sun ? 'text-danger' : '' }}
                        {{-- 土曜なら青文字 --}}
                        {{ $cell['date']->dayOfWeek == DayOfWeek::sat ? 'text-primary' : '' }}

                        {{-- designbaseテンプレート --}}
                        {{ $cell['date'] == Carbon::today() ? ' current' : '' }}
                        "
                    >
                        <div class="clearfix">
                            {{-- 日付＆曜日（767px以下で表示） --}}
                            <div class="float-left d-md-none">
                                {{ $cell['date']->day . ' (' . DayOfWeek::getDescription($cell['date']->dayOfWeek) . ')' }}
                            </div>

                            {{-- ＋ボタン --}}
                            <div class="float-right">
                                @can('posts.create',[[null, $frame->plugin_name, $buckets]])
                                    {{-- セル毎に予約追加画面呼び出し用のformをセット --}}
                                    <form action="{{URL::to('/')}}/plugin/reservations/editBooking/{{$page->id}}/{{$frame_id}}#frame-{{$frame_id}}" name="form_edit_booking_{{$frame_id}}_{{ $reservations->id }}_{{ $calendar_details['facility']->id }}_{{ $cell['date']->format('Ymd') }}" method="POST" class="form-horizontal">
                                        {{ csrf_field() }}
                                        {{-- 施設予約ID --}}
                                        <input type="hidden" name="reservations_id" value="{{ $reservations->id }}">
                                        {{-- 施設ID --}}
                                        <input type="hidden" name="facility_id" value="{{ $calendar_details['facility']->id }}">
                                        {{-- 対象日付 --}}
                                        <input type="hidden" name="target_date" value="{{ $cell['date']->format('Ymd') }}">
                                        {{-- ＋ボタンクリックでformサブミット --}}
                                        <a href="javascript:form_edit_booking_{{$frame_id}}_{{ $reservations->id }}_{{ $calendar_details['facility']->id }}_{{ $cell['date']->format('Ymd') }}.submit()">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        @if (isset($cell['bookings']))
                            @foreach ($cell['bookings'] as $booking)

                                {{-- 予約時間の表示 ＆ モーダルウィンドウ呼び出し --}}
                                @include('plugins.user.reservations.default.include_common_modal_call')

                            @endforeach
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
@endforeach
