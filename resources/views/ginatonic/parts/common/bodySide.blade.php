<section class="formSide pc">
    <h2>あなたの土地評価額（売却価額）はいくら？</h2>
    <p>最短<span class="green"><span class="l">45</span>秒</span>で最大<span class="green"><span class="l">6</span>社</span>に一括無料査定</p>
    <?php $idNo++; ?>
    @include('common.bodySfForm')
</section>
<section class="prg">
    <h2 class="crown">
        @if ($body['where'] == 'index')
            日本全国の
        @else
            {{$body['areaCaptionOf']}}
        @endif
        地価公示価格<span class="l">市区町村ランキング</span></h2>
    <table class="tableRanking">
        <colgroup class="col1">
        <colgroup class="col2">
        <colgroup class="col3">
        <colgroup class="col4">
        <tr>
            <th>順位</th>
            <th>市区町村</th>
            <th>平均単価/m<sup>2</sup></th>
            <th>対前年比</th>
        </tr>
        @foreach($body['ranking']['city'] as $city)
            <tr>
                <td class="rank">{{$city['ranking']}}</td>
                <td><a href="{{$city['link']}}">{{$city['area']}}</a></td>
                <td class="value">{{$city['average']}}/m<sup>2</sup></td>
                @if ($city['compared'] == 'up')
                    <td class="ratio up">
                @elseif ($city['compared'] === 'down')
                    <td class="ratio down">
                @else
                    <td class="ratio flat">
                @endif
                    {{$city['yearOverYear']}}</td>
            </tr>
        @endforeach
    </table>
</section>

