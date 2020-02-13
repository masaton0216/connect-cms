<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

use App\Userable;

/**
 * コードテーブルのモデル
 *
 * @author 牟田口 満 <mutaguchi@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category コード管理
 * @package Model
 */
class Codes extends Model
{
    // 保存時のユーザー関連データの保持
    use Userable;

    /**
     * create()やupdate()で入力を受け付ける ホワイトリスト
     */
    protected $fillable = [
        'plugin_name',
        'buckets_id',
        'prefix',
        'type_name', 
        'type_code1',
        'type_code2',
        'type_code3',
        'type_code4',
        'type_code5',
        'code',
        'value',
        'display_sequence',
    ];
}