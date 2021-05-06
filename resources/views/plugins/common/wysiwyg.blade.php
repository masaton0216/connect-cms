{{--
 * 編集画面(データ選択)テンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category プラグイン共通
--}}
@php
    // テーマ固有書式
    $style_formats_file = '';
    $style_formats_path = public_path() . '/themes/' . $theme . '/wysiwyg/style_formats.txt';
    $style_formats_group_default_path = public_path() . '/themes/' . $theme_group_default . '/wysiwyg/style_formats.txt';
    $style_formats_default_path = public_path() . '/themes/Defaults/Default/wysiwyg/style_formats.txt';
    if (File::exists($style_formats_path)) {
        $style_formats_file = File::get($style_formats_path);
    }
    else if (File::exists($style_formats_group_default_path)) {
        $style_formats_file = File::get($style_formats_group_default_path);
    }
    else if (File::exists($style_formats_default_path)) {
        $style_formats_file = File::get($style_formats_default_path);
    }

    // テーマ固有スタイル
    $block_formats_file = '';
    $block_formats_path = public_path() . '/themes/' . $theme . '/wysiwyg/block_formats.txt';
    $block_formats_group_default_path = public_path() . '/themes/' . $theme_group_default . '/wysiwyg/block_formats.txt';
    $block_formats_default_path = public_path() . '/themes/Defaults/Default/wysiwyg/block_formats.txt';
    if (File::exists($block_formats_path)) {
        $block_formats_file = File::get($block_formats_path);
    }
    else if (File::exists($block_formats_group_default_path)) {
        $block_formats_file = File::get($block_formats_group_default_path);
    }
    else if (File::exists($block_formats_default_path)) {
        $block_formats_file = File::get($block_formats_default_path);
    }

    // CSS
    $content_css_file = '';
    $content_css_path = public_path() . '/themes/' . $theme . '/wysiwyg/content_css.txt';
    $content_css_group_default_path = public_path() . '/themes/' . $theme_group_default . '/wysiwyg/content_css.txt';
    $content_css_default_path = public_path() . '/themes/Defaults/Default/wysiwyg/content_css.txt';
    if (File::exists($content_css_path)) {
        $content_css_file = File::get($content_css_path);
    }
    else if (File::exists($content_css_group_default_path)) {
        $content_css_file = File::get($content_css_group_default_path);
    }
    else if (File::exists($content_css_default_path)) {
        $content_css_file = File::get($content_css_default_path);
    }

    // テーブル
    $table_class_list_file = '';
    $table_class_list_path = public_path() . '/themes/' . $theme . '/wysiwyg/table_class_list.txt';
    $table_class_group_default_path = public_path() . '/themes/' . $theme_group_default . '/wysiwyg/table_class_list.txt';
    $table_class_default_path = public_path() . '/themes/Defaults/Default/wysiwyg/table_class_list.txt';
    if (File::exists($table_class_list_path)) {
        $table_class_list_file = File::get($table_class_list_path);
    }
    else if (File::exists($table_class_group_default_path)) {
        $table_class_list_file = File::get($table_class_group_default_path);
    }
    else if (File::exists($table_class_default_path)) {
        $table_class_list_file = File::get($table_class_default_path);
    }

    // テーブルセル
    $table_cell_class_list_file = '';
    $table_cell_class_list_path = public_path() . '/themes/' . $theme . '/wysiwyg/table_cell_class_list.txt';
    $table_cell_class_group_default_path = public_path() . '/themes/' . $theme_group_default . '/wysiwyg/table_cell_class_list.txt';
    $table_cell_class_default_path = public_path() . '/themes/Defaults/Default/wysiwyg/table_cell_class_list.txt';
    if (File::exists($table_cell_class_list_path)) {
        $table_cell_class_list_file = File::get($table_cell_class_list_path);
    }
    else if (File::exists($table_cell_class_group_default_path)) {
        $table_cell_class_list_file = File::get($table_cell_class_group_default_path);
    }
    else if (File::exists($table_cell_class_default_path)) {
        $table_cell_class_list_file = File::get($table_cell_class_default_path);
    }

    // テーマ固有 箇条書きリスト（ULタグ）の表示設定
    $advlist_bullet_lists_file = '';
    $advlist_bullet_lists_path = public_path() . '/themes/' . $theme . '/wysiwyg/advlist_bullet_lists.txt';
    $advlist_bullet_lists_group_default_path = public_path() . '/themes/' . $theme_group_default . '/wysiwyg/advlist_bullet_lists.txt';
    $advlist_bullet_lists_default_path = public_path() . '/themes/Defaults/Default/wysiwyg/advlist_bullet_lists.txt';
    if (File::exists($advlist_bullet_lists_path)) {
        $advlist_bullet_lists_file = File::get($advlist_bullet_lists_path);
    }
    else if (File::exists($advlist_bullet_lists_group_default_path)) {
        $advlist_bullet_lists_file = File::get($advlist_bullet_lists_group_default_path);
    }
    else if (File::exists($advlist_bullet_lists_default_path)) {
        $advlist_bullet_lists_file = File::get($advlist_bullet_lists_default_path);
    }

    // テーマ固有 番号箇条書きリスト（OLタグ）の表示設定
    $advlist_number_lists_file = '';
    $advlist_number_lists_path = public_path() . '/themes/' . $theme . '/wysiwyg/advlist_number_lists.txt';
    $advlist_number_lists_group_default_path = public_path() . '/themes/' . $theme_group_default . '/wysiwyg/advlist_number_lists.txt';
    $advlist_number_lists_default_path = public_path() . '/themes/Defaults/Default/wysiwyg/advlist_number_lists.txt';
    if (File::exists($advlist_number_lists_path)) {
        $advlist_number_lists_file = File::get($advlist_number_lists_path);
    }
    else if (File::exists($advlist_number_lists_group_default_path)) {
        $advlist_number_lists_file = File::get($advlist_number_lists_group_default_path);
    }
    else if (File::exists($advlist_number_lists_default_path)) {
        $advlist_number_lists_file = File::get($advlist_number_lists_default_path);
    }

    // テーマ固有 簡易テンプレート
    $templates_file = '';
    $templates_path = public_path() . '/themes/' . $theme . '/wysiwyg/templates.txt';
    $templates_group_default_path = public_path() . '/themes/' . $theme_group_default . '/wysiwyg/templates.txt';
    $templates_default_path = public_path() . '/themes/Defaults/Default/wysiwyg/templates.txt';
    if (File::exists($templates_path)) {
        $templates_file = File::get($templates_path);
    }
    else if (File::exists($templates_group_default_path)) {
        $templates_file = File::get($templates_group_default_path);
    }
    else if (File::exists($templates_default_path)) {
        $templates_file = File::get($templates_default_path);
    }

    // TinyMCE Body クラス
    $body_class = '';
    if ($frame->area_id == 0) {
        $body_class = 'ccHeaderArea';
    }
    elseif ($frame->area_id == 1) {
        $body_class = 'ccCenterArea ccLeftArea';
    }
    elseif ($frame->area_id == 2) {
        $body_class = 'ccCenterArea ccMainArea';
    }
    elseif ($frame->area_id == 3) {
        $body_class = 'ccCenterArea ccRightArea';
    }
    elseif ($frame->area_id == 4) {
        $body_class = 'ccFooterArea';
    }

    // plugins
    $plugins = 'file image imagetools media link autolink preview textcolor code table lists advlist template ';
    if (config('connect.OSWS_TRANSLATE_AGREEMENT') === true) {
        $plugins .= ' translate';
    }
    $plugins = "plugins  : '" . $plugins . "',";

    // toolbar
    $toolbar = 'undo redo | bold italic underline strikethrough subscript superscript | formatselect | styleselect | forecolor backcolor | removeformat | table | numlist bullist | blockquote | alignleft aligncenter alignright alignjustify | outdent indent | link jbimages | image file media | preview | code ';
    // 簡易テンプレート設定がない場合、テンプレート挿入ボタン押下でエラー出るため、設定ない場合はボタン表示しない。
    if (! empty($templates_file)) {
        $toolbar .= '| template ';
    }
    if (config('connect.OSWS_TRANSLATE_AGREEMENT') === true) {
        $toolbar .= '| translate ';
    }
    $toolbar = "toolbar  : '" . $toolbar . "',";

    // imagetools_toolbar (need imagetools plugin)
    // rotateleft rotateright flipv fliphは、フォーカスが外れないと images_upload_handler が走らないため、使わない。フォーカスが外さないで確定すると、固定記事の場合、コンテンツカラム内にbase64画像（超長い文字列)がそのまま送られ、カラムサイズオーバーでSQLエラーになる。
    // しかし editimage (画像の編集) であれば、モーダルを開いてそこで編集し「保存」ボタンを押下時に images_upload_handler が走るため、base64問題を回避できる。
    $imagetools_toolbar = "imagetools_toolbar  : 'editimage imageoptions',";

@endphp
<input type="hidden" name="page_id" value="{{$page_id}}">
<script type="text/javascript" src="{{url('/')}}/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        @if(isset($target_class) && $target_class)
            selector : 'textarea.{{$target_class}}',
        @else
            selector : 'textarea',
        @endif

        language : 'ja',
        base_url : '{{url("/")}}',

        {{-- plugins --}}
        {!!$plugins!!}

        {{-- imagetools_toolbar --}}
        {!!$imagetools_toolbar!!}

        {{-- formatselect = スタイル, styleselect = 書式 --}}
        {!!$toolbar!!}

        {{-- テーマ固有書式 --}}
        {!!$style_formats_file!!}

        {{-- テーマ固有スタイル --}}
        {!!$block_formats_file!!}

        {{-- テーマ固有 箇条書きリスト（ULタグ）の表示設定 --}}
        {!!$advlist_bullet_lists_file!!}

        {{-- テーマ固有 番号箇条書きリスト（OLタグ）の表示設定 --}}
        {!!$advlist_number_lists_file!!}

        {{-- テーマ固有 簡易テンプレート設定 --}}
        {!!$templates_file!!}

        menubar  : '',
        relative_urls : false,
        height: 300,
        branding: false,
        //forced_root_block : false,
        valid_children : "+body[style|input],+a[div|p],",
        //extended_valid_elements : "script[type|charset|async|src]"
        //                         +",div[id|class|align|style|clear]"
        //                         +",input[*]"
        //                         +",cc[*]",
        //extended_valid_elements : "script[type|charset|async|src],cc[value]",
        valid_elements : '*[*]',
        extended_valid_elements : '*[*]',

        {{-- CSS --}}
        {!!$content_css_file!!}

        body_class : "{{$body_class}}",

        file_picker_types: 'file image media',
        media_live_embeds: true,

        image_caption: true,
        image_title: true,
        image_class_list: [
            {title: 'Responsive', value: 'img-fluid'},
            {title: 'None', value: 'none'},
        ],
        invalid_styles: {
            'table': 'height width border-collapse',
            'tr': 'height width',
            'th': 'height width',
            'td': 'height width',
        },
        //table_resize_bars: false,
        //object_resizing: 'img',
        //table_default_attributes: {
        //    class: 'table'
        //},
        {{-- テーブル --}}
        {!!$table_class_list_file!!}

        {{-- テーブルセル --}}
        {!!$table_cell_class_list_file!!}

        // 画像アップロード・ハンドラ
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{url('/')}}/upload');

            xhr.onload = function() {
                var json;

                // アップロード後に押せない全ボタンを解除する
                $(':button').prop('disabled', false);
                // console.log("転送が完了しました。");

                if (xhr.status < 200 || xhr.status >= 300) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            // アップロード中は全ボタンを押させない
            $(':button').prop('disabled', true);
            // console.log("転送開始");

            formData = new FormData();

            // bugfix: 「blobInfo.blob().name」は新規のアップロードの際しか名前が設定されないが、「blobInfo.filename()」は新規の時も回転などimagetoolsを使用した時も
            // 常に設定されているので、typeofの評価は不要で常に fileName = blobInfo.filename(); でよいのではと思います。
            // https://github.com/opensource-workshop/connect-cms/pull/353#issuecomment-636411186
            //
            // if( typeof(blobInfo.blob().name) !== undefined )
            //     fileName = blobInfo.blob().name;
            // else
            //     fileName = blobInfo.filename();
            fileName = blobInfo.filename();

            var tokens = document.getElementsByName("csrf-token");
            formData.append('_token', tokens[0].content);
            formData.append('file', blobInfo.blob(), fileName);
            formData.append('page_id', {{$page_id}});
            xhr.send(formData);
        }
    });
</script>
