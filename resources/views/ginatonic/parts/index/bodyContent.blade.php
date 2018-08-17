<!--bodyContent.blade.php-->
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
<section class="prg full">
    <h2 class="titlePrg cal">日本全国の地価公示価格</h2>
    @include('common.bodyPrefectureLink')
</section>
<section class="prg averageGraph">
    <h2 class="titlePrg cal">日本全体の地価公示価格平均推移グラフ </h2>
    <div>グラフが入ります</div>
    <p class="remark">※地価平均は全地点の公示価格平均値を算出、上昇率は新規測定地を除いた公示地点の平均上昇率</p>
</section>
<section class="prg">
    <h2 class="titlePrg crown">日本全国の地価公示価格 都道府県ランキング</h2>
    @include('ginatonic.parts.common.bodyTableRanking')
</section>

