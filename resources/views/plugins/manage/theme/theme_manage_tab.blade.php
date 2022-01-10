{{--
 * 編集画面tabテンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category テーマ管理
 --}}
<div class="frame-setting-menu">
    <nav class="navbar navbar-expand-md navbar-light bg-light py-1">
        <span class="d-md-none">処理選択 - テーマ管理</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbarLg">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="collapsingNavbarLg">
            <ul class="navbar-nav">
                <li role="presentation" class="nav-item">
                @if ($function == "index")
                    <span class="nav-link"><span class="active">ユーザ・テーマ</span></span>
                @else
                    <a href="{{url('/manage/theme')}}" class="nav-link">ユーザ・テーマ</a></li>
                @endif
                </li>
                <li role="presentation" class="nav-item">
                @if ($function == "generate")
                    <span class="nav-link"><span class="active">カスタムテーマ生成</span></span>
                @else
                    <a href="{{url('/manage/theme/generateIndex')}}" class="nav-link">カスタムテーマ生成</a></li>
                @endif
                </li>
                <li role="presentation" class="nav-item">
                @if ($function == "editCss")
                    <span class="nav-link"><span class="active">CSS編集</span></span>
                @endif
                </li>
                <li role="presentation" class="nav-item">
                @if ($function == "editJs")
                    <span class="nav-link"><span class="active">JavaScript編集</span></span>
                @endif
                </li>
                <li role="presentation" class="nav-item">
                @if ($function == "editName")
                    <span class="nav-link"><span class="active">テーマ名編集</span></span>
                @endif
                </li>
                <li role="presentation" class="nav-item">
                @if ($function == "listImages")
                    <span class="nav-link"><span class="active">画像管理</span></span>
                @endif
                </li>
            </ul>
        </div>
    </nav>
</div>
