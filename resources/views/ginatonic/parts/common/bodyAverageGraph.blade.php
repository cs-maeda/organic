<!-- bodyAverageGraph.blade.php -->
<section class="prg averageGraph">
    <h2 class="titlePrg cal">@if ($body['where'] == 'index')日本全体の@else{{$body['areaCaptionOf']}}@endif地価公示価格平均推移</h2>
    @if ($body['where'] != 'index')<p>{{$body['areaCaption']}}全体の地価公示価格と日本全体の地価公示価格の平均値を比較したグラフです</p>@endif
    <div>グラフが入ります</div>
    <p class="remark">※地価平均は全地点の公示価格平均値を算出、上昇率は新規測定地を除いた公示地点の平均上昇率</p>
</section>
