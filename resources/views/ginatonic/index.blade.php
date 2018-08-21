<!DOCTYPE html>
<html>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123345750-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-123345750-1');
        </script>
        @if ($body['where'] == 'index')
            <meta name="google-site-verification" content="rhXY8blnEGsN-T9Erg6z9XwngQOYqpjZgn7HD0wxkIA" />
        @endif

        @include('common.htmlHead')
        <link href="/css/ginatonic.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="/images/ginatonic/favicon.ico">
    </head>
    <body id="body_{{$body['where']}}">
        <?php $idNo = -1; ?>
        @include('ginatonic.parts.common.bodyHead')
        @include('ginatonic.parts.common.bodyMainImg')
        @if ($body['where'] != 'index')
            @include('common.bodyBreadcrumb')
        @endif
        <div id="contentArea" class="inner">
            <article id="mainArea">
                @if ($body['where'] == 'index')
                    @include('ginatonic.parts.index.bodyContent')
                @else
                    @include('ginatonic.parts.area.bodyContent')
                @endif
            </article>
            <article id="sideArea">
                @include('ginatonic.parts.common.bodySide')
            </article>
        </div>
        <div id="formBottom">
            <h2 class="catch1">土地売却なら<span class="orange">最大<span class="l">6</span>社</span>にて比較！</h2>
            <div class="catch2">
                <p class="top">土地を高く売るなら最短45秒の入力で、全国{{$body['form']['clientCount']}}社以上の不動産会社が対応！</p>
                <p class="bottom">最短45秒で土地評価額を査定 </p>
            </div>
            <?php $idNo++; ?>
            @include('common.bodySfForm')
        </div>
        @include('common.bodyFormButton')
        @include('common.bodyFoot')
    </body>
</html>
