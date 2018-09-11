<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125091823-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-125091823-1');
        </script>
        @if ($body['where'] == 'index')
            <meta name="google-site-verification" content="nK0DVnwV65HTXjs296mraHUcT32Eb0CjOMjlnkSCjN4" />
        @endif

        @include('common.htmlHead')
        <link href="/css/ginatonic.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="/images/ginatonic/favicon.ico">
    </head>
    <body id="body_{{$body['where']}}">
        <input type="hidden" id="prefectureId" value="{{$body['prefectureId']}}">
        <input type="hidden" id="prefectureAlphabet" value="{{$body['prefectureAlphabet']}}">
        <input type="hidden" id="cityId" value="{{$body['cityId']}}">
        <input type="hidden" id="cityAlphabet" value="{{$body['cityAlphabet']}}">
        <input type="hidden" id="areaCaptionOf" value="{{$body['areaCaptionOf']}}">

        <?php $idNo = -1; ?>
        @include('ginatonic.parts.common.bodyHead')
        @include('ginatonic.parts.common.bodyMainImg')
        @include('common.bodyBreadcrumb')
        <div id="contentArea" class="inner">
            <article id="mainArea">
                @if ($body['where'] == 'index')
                    @include('ginatonic.parts.index.bodyContent')
                @else
                    @include('ginatonic.parts.area.bodyContent')
                @endif
            </article>
            <article id="sideArea">
                @if ($body['where'] == 'city')
                    @include('ginatonic.parts.common.bodySideCity')
                @else
                    @include('ginatonic.parts.common.bodySide')
                @endif
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
