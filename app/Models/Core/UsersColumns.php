<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

use App\UserableNohistory;

class UsersColumns extends Model
{
    // 保存時のユーザー関連データの保持（履歴なしUserable）
    use UserableNohistory;

    // 更新する項目の定義
    protected $fillable = [
        'column_type',
        'column_name',
        'required',
        'caption',
        'caption_color',
        'place_holder',
        'rule_allowed_numeric',
        'rule_allowed_alpha_numeric',
        'rule_digits_or_less',
        'rule_max',
        'rule_min',
        'rule_regex',
        'rule_word_count',
        'display_sequence',
    ];
}
