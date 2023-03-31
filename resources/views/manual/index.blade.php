@extends("manual.common.main_full_norow")

@section('content_main')
<div class="card mt-3">
    <div class="card-header text-white bg-primary">Connect-CMS オンライン・マニュアル</div>
    <div class="card-body">
        @if (\App\Models\Core\Dusks::hasMp4File('top/index/index/mp4/' . config('connect.manual_voiceid') . '/_video.mp4'))
            <div class="row">
                <div class="col-lg-4 p-0">
                    <div class="embed-responsive embed-responsive-16by9">
                        @if (\App\Models\Core\Dusks::hasPosterFile('top/index/index/mp4/' . config('connect.manual_voiceid') . '/_poster.png'))
                        <video src="./top/index/index/mp4/{{config('connect.manual_voiceid')}}/_video.mp4"
                               class="embed-responsive-item"
                               poster="./top/index/index/mp4/{{config('connect.manual_voiceid')}}/_poster.png"
                               controls>
                        </video>
                        @else
                        <video src="./top/index/index/mp4/{{config('connect.manual_voiceid')}}/_video.mp4"
                               class="embed-responsive-item"
                               controls>
                        </video>
                        @endif
                    </div>
                </div>

                <div class="col-lg-8">
                    <p>ようこそ、Connect-CMS のマニュアルへ。</p>
                    <p>まずは、バッジ・メニューから、見たいカテゴリをクリックしましょう。</p>
                    <p>
                        {{-- バッジ・メニュー --}}
                        @include('manual.common.badge_menu')
                    </p>
                    <p>このマニュアルを生成したConnect-CMSのバージョン：{{config('version.cc_version')}}</p>
                </div>
            </div>
        @else
            <p>ようこそ、Connect-CMS のマニュアルへ。</p>
            <p>まずは、バッジ・メニューから、見たいカテゴリをクリックしましょう。</p>
            {{-- バッジ・メニュー --}}
            @include('manual.common.badge_menu')
            <p>このマニュアルを生成したConnect-CMSのバージョン：(v{{config('version.cc_version')}})</p>
        @endif
    </div>
</div>
<div class="card">
    <div class="card-header text-white bg-primary">Connect-CMS マニュアル・ダウンロード</div>
    <div class="card-body">
        <p>Connect-CMS のマニュアルをPDF でダウンロードできます。</p>
        <p>用途に応じて必要な種類をダウンロードしてお使いください。</p>
        <ul>
            <li><b>標準機能マニュアル</b>
                <table class="table table-bordered table-responsive-md w-auto">
                <tbody>
                    <tr>
                        <th nowrap rowspan="2" class="align-middle text-center">全機能版</th>
                        <td colspan="2" class="text-center"><a href="./pdf/manual.pdf" target="_blank">管理者編・一般編合成マニュアル</a></td>
                    </tr>
                    <tr>
                        <td><a href="./pdf/manual_manage.pdf" target="_blank">管理者編 マニュアル</a></td>
                        <td><a href="./pdf/manual_user.pdf" target="_blank">一般ユーザ編 マニュアル</a></td>
                    </tr>
                    <tr>
                        <th nowrap rowspan="2" class="align-middle text-center">基本機能版</th>
                        <td colspan="2" class="text-center"><a href="./pdf/manual_basic.pdf" target="_blank">管理者編・一般編合成マニュアル</a></td>
                    </tr>
                    <tr>
                        <td><a href="./pdf/manual_manage_basic.pdf" target="_blank">管理者編 マニュアル</a></td>
                        <td><a href="./pdf/manual_user_basic.pdf" target="_blank">一般ユーザ編 マニュアル</a></td>
                    </tr>
                </tbody>
                </table>
            </li>
            <li><b>オプション機能マニュアル</b>
                <ul>
                    <li><a href="./pdf/manual_connect-study.pdf" target="_blank">Connect-Study編 マニュアル</a>
                </li></ul>
            </li>
        </ul>
    </div>
</div>
{{--
<div class="row mt-3">
    <div class="col-sm">
        <div class="card">
            <div class="card-header text-white bg-primary">Connect-CMS 仕様</div>
            <div class="card-body">
                <p>Connect-CMS を実装する際の元の仕様をダウンロードできます。</p>

                <table class="table" style="width: auto;">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">テキスト形式</th>
                        <th scope="col">PDF形式</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">概要版</th>
                        <td><a href="./spec/spec_summary.txt" target="_blank">概要版仕様 テキスト形式</a></td>
                        <td><a href="./spec/spec_summary.pdf" target="_blank">概要版仕様 PDF形式</a></td>
                    </tr>
                    <tr>
                        <th scope="row">詳細版</th>
                        <td><a href="./spec/spec_detail.txt" target="_blank">詳細版仕様 テキスト形式</a></td>
                        <td><a href="./spec/spec_detail.pdf" target="_blank">詳細版仕様 PDF形式</a></td>
                    </tr>
                </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
--}}
<div class="row mt-3">
    <div class="col-sm">
        <div class="card">
            <div class="card-header text-white bg-primary">Connect-CMS 情報源</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dd class="col-md-2"><a href="https://connect-cms.jp/" target="_blank">Connect-CMS公式サイト</a></dd>
                    <dd class="col-md-10">フォーラム掲示板や基本的な情報はこちらを参照してください。</dd>
                </dl>
                <dl class="row mb-0">
                    <dd class="col-md-2"><a href="https://market.connect-cms.jp/" target="_blank">Connect-CMSマーケット</a></dd>
                    <dd class="col-md-10">Connect-CMSのテーマや役立つデータの配布や販売、個別の講習や教育を受け付けするサイトです。</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-sm">
        <div class="card">
            <div class="card-header text-white bg-primary">ライセンス</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dd class="col-md-2">Connect-CMS のライセンス</dd>
                    <dd class="col-md-10">ソフトウェアとしての Connect-CMS は MIT ライセンスで公開しています。<br /><a href="https://github.com/opensource-workshop/connect-cms/blob/master/LICENSE" target="_blank">https://github.com/opensource-workshop/connect-cms/blob/master/LICENSE</a></dd>
                </dl>
                <dl class="row mb-0">
                    <dd class="col-md-2">ドキュメントのライセンス</dd>
                    <dd class="col-md-10">Connect-CMS マニュアルは GFDL ライセンスで公開しています。<br /><a href="./LICENSE.md" target="_blank">LICENSE.md</a></dd>
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
