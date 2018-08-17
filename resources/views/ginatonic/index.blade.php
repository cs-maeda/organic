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
        @include('ginatonic/parts/common/bodyMainImg')
        @if ($body['where'] != 'index')
            @include('common.bodyBreadcrumb')
        @endif
        <div id="contentArea" class="inner">
            <article id="mainArea">
                @if ($body['where'] == 'index')
                    <section class="prg">
                        <h2 class="titlePrg dsp">地価公示価格・土地評価額がわかるサイトの特徴</h2>
                        <p class="textPrg">国土交通省が毎年発表している地価公示価格を掲載しています。都道府県、市区町村、{{--
                            --}}町域、駅周辺ごとに分けて掲載したり、年ごとの推移が分かるグラフ、周辺エリアとの比較ができるランキング、{{--
                            --}}地図表示など、見やすいよう工夫していますので是非参考にしてください。<br>
                            また、地価公示価格だけでなく、実際に売買される際の目安となる土地評価額を知りたい方のために、査定依頼の窓口も用意しています。{{--
                            --}}土地評価額は不動産会社によって差が出る場合が多いため、当サイトでは無料で複数社に一括査定依頼ができるようにしました。{{--
                            --}}「最短45秒で無料査定」のフォームから依頼してみてください。<br>
                            なお、当サイトでは国土交通省公表による標準地ごとの地価公示価格データを使用しております。<br>
                            各エリアごとの平均値、変動率、地価ランキングは、国土交通省公表のデータに基づき、当サイトが独自に集計したものです。</p>
                    </section>
                    <section class="prg">
                        <h2 class="titlePrg cal">日本全国の地価公示価格</h2>
                        @include('common.bodyPrefectureLink')
                    </section>
                @endif
            </article>
            <article id="sideArea">
                <section class="formSide pc">
                    <h2>あなたの土地評価額（売却価額）はいくら？</h2>
                    <p>最短<span class="green"><span class="l">45</span>秒</span>で最大<span class="green"><span class="l">6</span>社</span>に一括無料査定</p>
                    <?php $idNo++; ?>
                    @include('common.bodySfForm')
                </section>
            </article>
        </div>


        @if ($body['where'] == 'index')
            @include('iacsicc/parts/index/bodyContent')
        @else
            @include('iacsicc/parts/area/bodyContent')
        @endif
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
