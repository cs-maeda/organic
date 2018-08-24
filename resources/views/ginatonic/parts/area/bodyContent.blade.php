<!--bodyContent.blade.php-->
<section class="prg">
    <h2 class="titlePrg dsp">{{$body['areaCaptionOf']}}<br>
        地価公示価格と土地評価額（実際の売却価格）について</h2>
    <p class="textPrg">{{$body['areaCaptionOf']}}地価公示価格を掲載しています。年ごとの推移が分かるグラフ、周辺エリアとの比較ができるランキングなども是非参考にしてください。{{--
        --}}また、地価公示価格だけでなく、実際に売買される際の目安となる土地評価額を知りたい方のために、査定依頼の窓口も用意しています。{{--
        --}}公共性が求められる税金（固定資産税や相続税）の計算の基準とされる地価公示価格や路線価と異なり、一般の土地取引には、{{--
        --}}不動産会社が近隣の取引実績などを参考に土地評価額を算定する場合が多く、さらには不動産会社によって差が出ると言われています。{{--
        --}}当サイトでは無料で複数社に一括査定依頼ができますので、「最短45秒で無料査定」のフォームから依頼してみてください。<br><br>
        なお、当サイトでは国土交通省公表による標準地ごとの地価公示価格データを使用しております。<br>
        各エリアごとの平均値、変動率、地価ランキングは、国土交通省公表のデータに基づき、当サイトが独自に集計したものです。</p>
</section>
@include('ginatonic.parts.common.bodyAverageAreaGraph')
@if ($body['where'] == 'city')
    <section class="prg">
        @include('ginatonic.parts.area.bodyTableLandPointList')
    </section>
@endif
<section class="prg">
    <h2 class="titlePrg cal">{{$body['areaCaption']}}周辺の地価公示価格</h2>
    @include('common.bodyAreaLink')
</section>
@if ($body['where'] == 'prefecture')
    @include('ginatonic.parts.area.bodyTableRankingPrefecture')
@endif
@include('ginatonic.parts.area.bodyAreaTrend')
<section class="prg full">
    <h2 class="titlePrg cal">都道府県一覧</h2>
    @include('common.bodyPrefectureLink')
</section>

