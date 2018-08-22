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
@include('ginatonic.parts.common.bodyAverageGraph')
<section class="prg">
    <h2 class="titlePrg cal">{{$body['areaCaptionOf']}}地価公示価格</h2>
    @include('common.bodyAreaLink')
</section>
<section class="prg">
    <h2 class="titlePrg crown">{{$body['parentAreaCaption']}}の地価公示価格 都道府県ランキング</h2>
    @include('ginatonic.parts.common.bodyTableRanking')
</section>
<section class="prg">
    <h2 class="titlePrg bubble">{{$body['areaCaptionOf']}}地価公示価格の傾向</h2>
    <p class="textPrg">{{$body['areaCaptionOf']}}地価公示価格の平均値は、47都道府県中○位で、前年比は○％の（上昇 or 下落）でした。<br>
        {{$body['areaCaption']}}内で最も地価公示価格の平均が高い地域は○○市で、1平方メートルあたり単価の平均は○○万円<br>
        また、最も地価公示価格の平均が低い地域は○○市で、1平方メートルあたり単価の平均は○○万円です。<br>
        変動率で見ると、最も上昇率が高かったのは○○市で前年比+○○％<br>
        最も上昇率が低かったのは○○市で前年比-○○％でした。。</p>
</section>
<section class="prg full">
    <h2 class="titlePrg cal">都道府県一覧</h2>
    @include('common.bodyPrefectureLink')
</section>

