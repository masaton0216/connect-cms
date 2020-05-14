<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

use App\UserableNohistory;

/**
 * コード検索グループテーブルのモデル
 *
 * @author 牟田口 満 <mutaguchi@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category コード管理
 * @package Model
 */
class CodesGroups extends Model
{
    // 保存時のユーザー関連データの保持（履歴なしUserable）
    use UserableNohistory;

    /**
    * create()やupdate()で入力を受け付ける ホワイトリスト
    */
    protected $fillable = [
        'name',
        'search_words',
        'display_sequence',
    ];
}
