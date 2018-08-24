    <h2 class="titlePrg crown">{{$body['areaCaptionOf']}}地価公示価格一覧</h2>
    <table class="tableRanking">
        <colgroup span="1" class="col1">
        <colgroup span="1" class="col2">
        <colgroup span="1" class="col3">
        <tr>
            <th>住所</th>
            <th>価格（円/m<sup>2</sup>）</th>
            <th>最寄り駅（バス停）</th>
        </tr>
        @foreach($body['pointList'] as $list)
            <tr>
                <td>{{$list['address']}}</td>
                <td class="value">{{$list['price']}}円/m<sup>2</sup></td>
                <td>{{$list['station']}}</td>
            </tr>
        @endforeach
    </table>
