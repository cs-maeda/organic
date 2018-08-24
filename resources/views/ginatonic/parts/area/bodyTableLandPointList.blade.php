<script>
    $().ready(function()
    {
        $('#point tr:nth-child(21)').attr('id', 'rowNumber').addClass('showLine');

        $('#showPointData').on('click',
        function(){
            if($('#point').hasClass('show')){
                $('#point').removeClass('show');
                $(this).text('全てのデータを表示');
            } else {
                $('#point').addClass('show');
                $(this).text('閉じる');
            }
        });
        
    });
</script>


<h2 id="pointTitle" class="titlePrg crown">{{$body['areaCaptionOf']}}地価公示価格一覧</h2>
<table id="point" class="tableRanking">
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
@if(count($body['pointList']) > 20)
    <a href="#rowNumber" id="showPointData">全てのデータを表示</a>
@endif
