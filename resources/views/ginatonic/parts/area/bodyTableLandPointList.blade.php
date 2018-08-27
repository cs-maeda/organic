<script>
    $().ready(function()
    {
        $('.listRanking li:nth-child(21)').attr('id', 'showPoint');
        $('#showPointData').on('click',
        function(){
            if($('.listRanking li').hasClass('open')){
                $('.listRanking li').removeClass('open');
                $(this).text('全てのデータを表示');
            } else {
                $('.listRanking li').addClass('open');
                $(this).text('閉じる');
            }
        });
        
    });
</script>


<h2 id="pointTitle" class="titlePrg crown">{{$body['areaCaptionOf']}}地価公示価格一覧</h2>
<ul class="listRanking">
    <li class="head">
        <span class="col1">住所</span>
        <span class="col2">価格（円/m<sup>2</sup>）</span>
        <span class="col3">最寄り駅（バス停）</span>
    </li>
    @foreach($body['pointList'] as $list)
    <li>
        <span class="col1">{{$list['address']}}</span>
        <span class="value col2">{{$list['price']}}円/m<sup>2</sup></span>
        <span class="col3">{{$list['station']}}</span>
    </li>
    @endforeach
</ul>

@if(count($body['pointList']) > 20)
    <a href="#showPoint" id="showPointData">全てのデータを表示</a>
@endif
