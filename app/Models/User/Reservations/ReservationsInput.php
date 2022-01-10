<?php

namespace App\Models\User\Reservations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

use App\UserableNohistory;

use App\Enums\ConnectLocale;
use App\Enums\DayOfWeek;

class ReservationsInput extends Model
{
    // 保存時のユーザー関連データの保持（履歴なしUserable）
    use UserableNohistory;

    // 更新する項目の定義
    protected $fillable = [
        'reservations_id',
        'facility_id',
        'start_datetime',
        'end_datetime',
        'first_committed_at',
        'status',
    ];

    protected $dates = ['start_datetime', 'end_datetime'];

    /**
     * 表示する予約日付
     * start_datetime は not nullのため、空にならない想定
     */
    public function displayDate()
    {
        if (App::getLocale() == ConnectLocale::en) {
            $display = $this->start_datetime->format('j M Y');
        } else {
            $display = $this->start_datetime->format('Y年n月j日');
        }
        $display .= ' (' . DayOfWeek::getDescription($this->start_datetime->dayOfWeek) . ')';

        return $display;
    }
}
