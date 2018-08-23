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



        <tr>
            <td class="rank top1">1位</td>
            <td>
                <a href="/tokyo/">東京都</a>
            </td>
            <td class="value">
                96万8067円 / m<sup>2</sup>
            </td>
            <td class="ratio up">+ 8.28 ％</td>
        </tr>
        <tr>
            <td class="rank r top2">2位</td>
            <td>
                <a href="/osaka/">大阪府</a>
            </td>
            <td class="value">
                30万8067円 / m<sup>2</sup>
            </td>
            <td class="ratio up">+ 8.28 ％</td>
        </tr>
        <tr>
            <td class="rank top3">3位</td>
            <td>
                <a href="/kanagawa/">神奈川県</a>
            </td>
            <td class="value">
                30万8067円 / m<sup>2</sup>
            </td>
            <td class="ratio up">+ 8.28 ％</td>
        </tr>
        <tr>
            <td class="rank">4位</td>
            <td>
                <a href="/kanagawa/">神奈川県</a>
            </td>
            <td class="value">
                30万8067円 / m<sup>2</sup>
            </td>
            <td class="ratio down">- 8.28 ％</td>
        </tr>
        <tr>
            <td class="rank">5位</td>
            <td>
                <a href="http://shindo.ginatonic.net/tokyo/">神奈川県</a>
            </td>
            <td class="value">
                30万8067円 / m<sup>2</sup>
            </td>
            <td class="ratio flat">8.28 ％</td>
        </tr>
    </table>
