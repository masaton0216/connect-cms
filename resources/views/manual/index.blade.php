@extends("manual.common.main_full_norow")

@section('content_main')
<div class="row mt-3">
    <div class="col-sm">
        <div class="card">
            <div class="card-header text-white bg-primary">Connect-CMS マニュアル</div>
            <div class="card-body">
                <p>ようこそ、Connect-CMS のマニュアルへ。</p>
                <p>まずは、バッジ・メニューから、見たいカテゴリをクリックしましょう。</p>
                {{-- バッジ・メニュー --}}
                @include('manual.common.badge_menu')
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm">
        <div class="card">
            <div class="card-header text-white bg-primary">Connect-CMS 情報源</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dd class="col-md-2"><a href="https://connect-cms.jp/" target="_blank">Connect-CMS公式サイト</a></dd>
                    <dd class="col-md-10">フォーラム掲示板や基本的な情報はこちらを参照してください。</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm">
        <div class="card">
            <div class="card-header text-white bg-primary">動作環境</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dd class="col-md-2"><a href="https://github.com/opensource-workshop/connect-cms/wiki/Install" target="_blank">サーバ側の動作環境(Github)</a></dd>
                    <dd class="col-md-10"><p>ご自分でインストールなど行う方はこちらを参照してください。</p></dd>
                    <dd class="col-md-2">PCでの動作環境</dd>
                    <dd class="col-md-10"><ul><li>Chrome、Firefox、Edge（Chromium版）、Safari（Mac）の最新バージョン</li></ul></dd>
                    <dd class="col-md-2">スマートフォンでの動作環境</dd>
                    <dd class="col-md-10"><ul><li>iPhone、Androidの標準ブラウザの最新バージョン</li></ul></dd>
                </dl>
                <p>その他、基本的なブラウザでは、PC、スマートフォンとも動作するように設計、実装しております。<br />
                   もし、うまく動かないよ。というパターンがありましたら、お使いのOS、ブラウザとそれぞれのバージョンを公式サイトのお問い合わせフォームでお知らせください。<br />
                   可能な範囲で調査したいと思います。
                </p>
                <p>※ InternetExplorer は動作確認対象外とさせていただいております。</p>
            </div>
        </div>
    </div>
</div>
@endsection
