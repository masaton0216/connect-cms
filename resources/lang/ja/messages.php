<?php

/*
 |-----------------------------------------------------------------
 | 多言語対応 画面キャプションの日本語ファイル
 |-----------------------------------------------------------------
 */
$messages = [
    'confirm' => '確定',
    'subject' => '対象',
    'kinds' => '種別',
    'authors_etc' => '著者等',
    'title' => 'タイトル',
    'year_month' => '年月',
    'to_this_month' => '今月へ',
    'to_today' => '今日へ',
    'month' => '月',
    'week' => '週',
    'reservation_details' => '予約詳細',
    'detail' => '詳細',
    'day_of_use' => '利用日',
    'time_of_use' => '利用時間',
    'close' => '閉じる',
    'edit' => '編集',
    'delete' => '削除',
    'to_confirm' => '確認画面へ',
    'cancel' => 'キャンセル',
    'submit' => '送信',
    'temporary_regist' => '仮登録',
    'main_regist' => '本登録',
    'required' => '必須',
    'to_list' => '一覧へ',
    'next' => '次へ',
    'previous' => '前へ',
    'magazine_name' => '誌名',
    'meeting_name' => '会議名',
    'enter_same_email' => '同じメールアドレスを入力',
    'not_match_confirmation_value' => 'が確認用の値と一致しません。',
    'entered_time_is_invalid' => '入力した時間の前後関係が不正です。',
    'cannot_be_delete_refers_to_the_information' => '削除しようとしている情報を参照している箇所がある為、削除できません。',
    'there_is_an_error' => 'エラーがあります。',
    'there_is_an_error_refer_to_the_message_of_each_item' => 'エラーの詳細は各項目のメッセージを参照してください。',
    'both_required' => '両方の項目を入力してください。',
    'search_results' => '検索結果',
    'cases' => '件',
    'people' => '名',
    'search_results_empty' => '検索結果が見つかりませんでした。',
    'input_user_name' => '表示されるユーザ名を入力します。',
    'input_login_id' => 'ログインするときのIDを入力します。',
    'input_email' => 'メールアドレスを入力します。',
    'input_password' => 'ログインするためのパスワードを入力します。',
    'input_password_confirm' => 'パスワードと同じものを入力してください。',
    'empty_bucket' => 'フレームの設定画面から、使用する:plugin_nameを選択するか、作成してください。',
    'empty_bucket_setting' => '選択画面から、使用する:plugin_nameを選択するか、作成してください。',
    'number_of_display' => '表示件数',
    'full_name' => '氏名',
    'affiliation' => '所属',
    'department' => '部署',
    'job_title' => '職名',
    'search_for_information_on_achievements' => '論文名、書籍名、著者名等の業績情報をあいまい検索可能です',
    'search' => '検索',
    'photo' => '写真',
    'research_seeds' => '研究シーズ',
    'words_in_research_seeds' => '研究シーズフリーワード',
    'facility_name' => '施設名',
    'area' => '地区',
    'discipline' => '研究分野（大分類）',
    'research_field' => '研究分野（小分類）',
    'gender' => '性別',
    'last_modified' => '最終更新日',
    'advanced_search' => '詳細検索',
    'male' => '男性',
    'female' => '女性',
    'other' => 'その他',
    'within_weeks' => ':count 週間以内',
    'within_months' => ':count か月以内',
    'unable_to_download_researcher_seeds' => '検索結果が多すぎるため、研究シーズをまとめてダウンロードできません。上限：:count 名',
    'download' => 'ダウンロード',
    'there_is_no_research_seeds_to_download' => 'ダウンロード可能な研究シーズがありません。',
    'researcher_info' => '研究者情報',
    'researchmap' => 'researchmap',
    'available' => '有',
    'not_available' => '無',
    'researcher_list' => '研究者一覧',
];

foreach ($messages as $key => $message) {
    // connect.configにcc_lang_ja_messages_ + messagesのkeyの値があったら置き換える
    if (config('connect.cc_lang_ja_messages_' . $key)) {
        $messages[$key] = config('connect.cc_lang_ja_messages_' . $key);
    }
}

return $messages;
