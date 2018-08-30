<!DOCTYPE html>
<html lang="ja">
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
        <link href="/css/iacsicc.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="/images/iacsicc/favicon.ico">
    </head>
    <body id="body_{{$body['where']}}">
        <?php $idNo = -1; ?>
        @include('common.bodyHead')
        @include('iacsicc/parts/common/bodyMainImg')
        <div class="formCopy">
            <p class="catch">{!! $body['copy'][3] !!}</p>
        </div>
        <?php $idNo++; ?>
        @include('common.bodySfForm')
        @if ($body['where'] != 'index')
            @include('common.bodyBreadcrumb')
        @endif

        @if ($body['where'] == 'index')
            @include('iacsicc/parts/index/bodyContent')
        @else
            @include('iacsicc/parts/area/bodyContent')
        @endif

        @include('common.bodyPrefectureLink')

        <div>
            <div class="formCopy">
                <p class="catch">
                {{$body['areaCaptionOf']}}不動産価格・不動産売買の相場で無料一括査定<br>
                <span class="red">最高価格</span>で売るなら<span class="red">最大6社</span>で比較検討<br>
                <span class="red">1分以内</span>の簡単入力！<br>
                @if ($body['where'] != 'index')
                    {{$body['areaCaptionOf']}}不動産価格に詳しい
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
        @include('common/bodyFoot')
    </body>
</html>
