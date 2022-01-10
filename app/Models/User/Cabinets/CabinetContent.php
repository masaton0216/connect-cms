<?php

namespace App\Models\User\Cabinets;

use Illuminate\Database\Eloquent\Model;

use App\UserableNohistory;
use App\Models\Common\Uploads;
use Kalnoy\Nestedset\NodeTrait;

class CabinetContent extends Model
{
    const is_folder_on = 1;
    const is_folder_off = 0;
    
    use NodeTrait;
    // 保存時のユーザー関連データの保持
    use UserableNohistory;

    // 更新する項目の定義
    protected $fillable = ['cabinet_id', 'upload_id', 'name', 'is_folder'];

    // NC2移行用の一時項目
    public $migrate_parent_id = 0;
    /**
     * キャビネットコンテントに紐づくアップロードを取得
     */
    public function upload()
    {
        // uploadsテーブルをこのレコードから見て 1:1 で紐づけ
        // キーは指定しておく。Uploads の id にこのレコードの upload_id を紐づける。
        // withDefault() を指定しておくことで、Uploads がないときに空のオブジェクトが返ってくるので、null po 防止。
        return $this->hasOne(Uploads::class, 'id', 'upload_id')->withDefault();
    }

    /**
     * 画面表示用のファイル名を取得する
     *
     * @return string  画面表示用のファイル名
     */
    public function getDisplayNameAttribute()
    {
        $displayName = $this->name;
        // 管理機能のアップロードファイル管理で、ファイル名の変更ができるため、
        // ファイルはアップロードテーブルから名称取得する
        if ($this->is_folder === self::is_folder_off) {
            $displayName = $this->upload->client_original_name;
        }
        return $displayName;
    }
}
