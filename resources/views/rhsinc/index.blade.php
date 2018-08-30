<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123441037-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-123441037-1');
        </script>

        @if ($body['where'] == 'index')
            <meta name="google-site-verification" content="-W-8Rg9QOacFPYLq1Bw55h6IjxjBunQZNPdQlHB2ds0" />
        @endif

        @include('common.htmlHead')
        <link href="/css/rhsinc.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="/images/rhsinc/favicon.ico">
    </head>
    <body id="body_{{$body['where']}}">
        <?php $idNo = -1; ?>
        @include('common.bodyHead')
        @include('rhsinc/parts/common/bodyMainImg')
        <div class="formCopy">
            <p class="catch">{!! $body['copy'][3] !!}</p>
        </div>
        <?php $idNo++; ?>
        @include('common.bodySfForm')
        @if ($body['where'] == 'index')
            @include('rhsinc/parts/index/bodyContent')
        @else
            @include('rhsinc/parts/area/bodyContent')
        @endif

        @include('common.bodyPrefectureLink')

        <div class="pcpd">
            <div class="formCopy bottom">
                <p class="catch">
                {{$body['areaCaptionOf']}}土地価格・土地売買の相場で無料一括査定<br>
                <span class="yellow">最高価格</span>で売るなら<span class="yellow">最大<span class="large">6</span>社</span>で比較検討<br>
                <span class="yellow">1分以内</span>の簡単入力！<br>
                @if ($body['where'] != 'index')
                    {{$body['areaCaptionOf']}}土地価格に詳しい
                @else
                    {{$body['form']['clientCount']}}社以上の
                @endif
                不動産会社が対応！
                </p>
            </div>
            <?php $idNo++; ?>
            @include('common.bodySfForm')
        </div>
        @include('common/bodyFormButton')
        @if ($body['where'] != 'index')
            @include('common.bodyBreadcrumb')
        @endif
        @include('common/bodyFoot')
    </body>
</html>
