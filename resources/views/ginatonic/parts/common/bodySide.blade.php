<section class="formSide pc">
    <h2>あなたの土地評価額（売却価額）はいくら？</h2>
    <p>最短<span class="green"><span class="l">45</span>秒</span>で最大<span class="green"><span class="l">6</span>社</span>に一括無料査定</p>
    <?php $idNo++; ?>
    @include('common.bodySfForm')
</section>
<section class="prg">
    @if ($body['where'] != 'city')
        <h2 class="crown">@if ($body['where'] == 'index')日本全国の
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
                    <td><a href="#">{{$city['area']}}</a></td>
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
    @else
        <h2 class="crown">{{$body['parentAreaCaption']}}の地価公示価格上昇率<span class="l">市区町村ランキング</span></h2>
        <div class="showRank">
            <p class="rank1"><span class="red">0位</span>/00000市区町村</p>
            <p class="rank2 up"><span class="red">00,000円</span>坪単価（+0.00％上昇）</p>
            <p class="rank2 down"><span class="red">00,000円</span>坪単価（+0.00％上昇）</p>
            <p class="rank2 flat"><span class="red">00,000円</span>坪単価（+0.00％上昇）</p>
            <p class="memo">※2017年発表の地価公示価格から算出</p>
        </div>
        <table class="tableRanking">
            <colgroup class="col1">
            <colgroup class="col2">
            <colgroup class="col3">
            <colgroup class="col4">
            <tr>
                <th>順位</th>
                <th>市区町村</th>
                <th>平米単価</th>
                <th>対前年比</th>
            </tr>
            <tr>
                <td class="rank">1位</td>
                <td><a href="#">東京都中央区</a></td>
                <td class="value">715万9079円/m<sup>2</sup></td>
                <td class="ratio up">+13.32％</td>
            </tr>
            <tr>
                <td class="rank">2位</td>
                <td><a href="#">東京都中央区</a></td>
                <td class="value">715万9079円/m<sup>2</sup></td>
                <td class="ratio down">+13.32％</td>
            </tr>
            <tr>
                <td class="rank">3位</td>
                <td><a href="#">東京都中央区</a></td>
                <td class="value">715万9079円/m<sup>2</sup></td>
                <td class="ratio flat">+13.32％</td>
            </tr>
            <tr>
                <td class="rank">4位</td>
                <td><a href="#">東京都中央区</a></td>
                <td class="value">715万9079円/m<sup>2</sup></td>
                <td class="ratio up">+13.32％</td>
            </tr>
        </table>
    @endif
</section>

