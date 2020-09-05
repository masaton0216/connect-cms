<?php

namespace App\Models\User\Linklists;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Userable;

class LinklistPost extends Model
{
    // 論理削除
    use SoftDeletes;

    // 保存時のユーザー関連データの保持
    use Userable;

    // 更新する項目の定義
    protected $fillable = ['linklist_id', 'title', 'url', 'description', 'target_blank_flag', 'display_sequence'];
}
