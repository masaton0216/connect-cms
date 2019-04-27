<html>
<head>

<meta name="token" content="{{ csrf_token() }}">

<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
    }
});


$(function(){
    $('#button').click(
        function() {
            $.ajax({
                type    : 'GET',
                url     : 'http://cms.localhost/test_dir/test.html', // url: は読み込むURLを表す
                dataType: 'html', // 読み込むデータの種類を記入
            }).done(function (results) {
                // 通信成功時の処理
                $('#text').html(results);
            }).fail(function (err) {
                // 通信失敗時の処理
                alert('ファイルの取得に失敗しました。');
            });
        }
    );
});
</script>

<script type="text/javascript">
$(document).ready(function () {

    $("#link01").on('click', function () {
        $.ajax({
            type    : 'GET',
            url     : 'http://cms.localhost/test/1',
            dataType: 'html',
        }).done(function (results) {
            // 通信成功時の処理
            $('#text').html(results);
        }).fail(function (err) {
            // 通信失敗時の処理
            alert('ファイルの取得に失敗しました。');
        });
    });
    $("#link02").on('click', function () {
        $.ajax({
            type    : 'POST',
            url     : 'http://cms.localhost/test/2',
            dataType: 'html',
        }).done(function (results) {
            // 通信成功時の処理
            $('#text').html(results);
        }).fail(function (err) {
            // 通信失敗時の処理
            alert('ファイルの取得に失敗しました。');
        });
    });
    $("#link03").on('click', function () {
        $("#text").html("リンク3がクリックされました。");
    });
})
</script>

</head>
<body>

<form action="/" method="post">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">タイトル</h4>
  <a id="link01" href="javascript:void(0);">リンク 1 - Get</a><br />
  <a id="link02" href="javascript:void(0);">リンク 2 - Post</a><br />
  <a id="link03" href="javascript:void(0);">リンク 3 - JS</a><br />
</div>
<div class="modal-body" id="text">
動的にいれたい内容を挿入
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" id="button">Ajax Post</button>
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
<input type="submit" class="btn btn-primary" value="Save changes" />
</div>

</form>

</body>
</html>
