    <h2 class="titlePrg crown">{{$body['areaCaptionOf']}}地価公示価格 都道府県ランキング</h2>
    <table class="tableRanking">
        <colgroup span="1" class="col1">
        <colgroup span="1" class="col2">
        <colgroup span="1" class="col3">
        <colgroup span="1" class="col4">
        <tr>
            <th>順位</th>
            <th>都道府県</th>
            <th>平均単価/m<sup>2</sup></th>
            <th>対前年比</th>
        </tr>
        @foreach($body['ranking']['prefecture'] as $prefecture)
            <tr>
                @if ($prefecture['ranking'] == '1位')
                    <td class="rank top1">
                @elseif ($prefecture['ranking'] == '2位')
                    <td class="rank top2">
                @elseif ($prefecture['ranking'] == '3位')
                    <td class="rank top3">
                @else
                    <td class="rank">
                @endif
                    {{$prefecture['ranking']}}</td>
                <td><a href="#">{{$prefecture['area']}}</a></td>
                <td class="value">{{$prefecture['average']}}/m<sup>2</sup></td>
                @if ($prefecture['compared'] == 'up')
                    <td class="ratio up">
                @elseif ($prefecture['compared'] === 'down')
                    <td class="ratio down">
                @else
                    <td class="ratio flat">
                @endif
                    {{$prefecture['yearOverYear']}}</td>
            </tr>
        @endforeach
    </table>