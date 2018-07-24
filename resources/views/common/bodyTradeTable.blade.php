<!-- priceList -->
<h2 class="recentPriceTitle">{{$body['areaCaptionOf']}}不動産売却実績・不動産価格一覧</h2>
<input type="hidden" id="prefectureId" value="{{$body['prefectureId']}}">
<input type="hidden" id="cityId" value="{{$body['cityId']}}">
<input type="hidden" id="townId" value="{{$body['townId']}}">
<input type="hidden" id="stationId" value="{{$body['stationId']}}">
<input type="hidden" id="pageNum" value="{{$body['tradeTable']['pageNum']}}">
<p class="showCount">{{number_format($body['figure']['own']['trade_count'])}}件中 <span class="start_row">{{number_format($body['tradeTable']['pageNum'])}}</span>-<span class="end_row">{{number_format($body['tradeTable']['pageNum'] + $body['tradeTable']['recordsCount'] - 1)}}</span>を表示</p>
<div id="trading">
    <table class="priceTable" border="0">
        <thead>
            <tr>
                <th rowspan="2">&nbsp;</th>
                <th rowspan="2">種類</th>
                <th rowspan="2">所在地</th>
                <th colspan="2">最寄駅</th>
                <th rowspan="2">取引総額</th>
                <th rowspan="2">面積(m<sup>2</sup>)</th>
                <th rowspan="2">建築年</th>
                <th rowspan="2">構造</th>
                <th rowspan="2">用途</th>
                <th rowspan="2">取引時期</th>
            </tr>
            <tr>
                <th>名称</th>
                <th>距離(分)</th>
            </tr>
        </thead>
        <tbody id="tradeRecords">
        </tbody>
    </table>
</div>
<div class="pager">
    <ul class="pagerList">
        <li class="arrow pageFirst end">&lt;&lt;</li>
        <li class="arrow pageBefore">&lt;</li>
        <li class="firstButton current">1</li>
        <li class="secondButton">2</li>
        <li class="thirdButton">3</li>
        <li class="forthButton">4</li>
        <li class="fifthButton">5</li>
        <li class="arrow pageNext">&gt;</li>
        <li class="arrow pageLast end pc">&gt;&gt;</li>
    </ul>
</div>

<script src="/js/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/sweetalert.css">
<script type="text/javascript">

    function clearTradeTable()
    {
        var tableObject = $('.priceTable');
        var tableBody = tableObject.find('tbody');
        tableBody.find('tr').remove();
    }

    function pagerControl(pager, pageNum)
    {
        var pageFirst = $('.pageFirst');
        pageFirst.hide();
        if (pager.buttonFirst === true){
            pageFirst.show();
        }
        var pageBefore = $('.pageBefore');
        pageBefore.hide();
        if (pager.buttonPrev === true){
            pageBefore.show();
        }
        var pageNext = $('.pageNext');
        pageNext.hide();
        if (pager.buttonNext === true){
            pageNext.show();
        }
        var pageLast = $('.pageLast');
        pageLast.hide();
        if (pager.buttonLast === true){
            pageLast.show();
        }
        var firstButton = $('.firstButton');
        var secondButton = $('.secondButton');
        var thirdButton = $('.thirdButton');
        var forthButton = $('.forthButton');
        var fifthButton = $('.fifthButton');
        $.each(pager.buttonNumber, function(i, item)
        {
            switch(i){
                case 0:
                    firstButton.removeClass("current");
                    if (item === pageNum){
                        firstButton.addClass("current");
                    }
                    firstButton.text(item);
                    firstButton.show();
                    break;
                case 1:
                    secondButton.removeClass("current");
                    if (item === pageNum){
                        secondButton.addClass("current");
                    }
                    secondButton.text(item);
                    secondButton.show();
                    break;
                case 2:
                    thirdButton.removeClass("current");
                    if (item === pageNum){
                        thirdButton.addClass("current");
                    }
                    thirdButton.text(item);
                    thirdButton.show();
                    break;
                case 3:
                    forthButton.removeClass("current");
                    if (item === pageNum){
                        forthButton.addClass("current");
                    }
                    forthButton.text(item);
                    forthButton.show();
                    break;
                case 4:
                    fifthButton.removeClass("current");
                    if (item === pageNum){
                        fifthButton.addClass("current");
                    }
                    fifthButton.text(item);
                    fifthButton.show();
                    break;
            }
        });
    }

    function storeTradeTable(items)
    {
        clearTradeTable();

        var tableObject = $('.priceTable');

        var num = items.tradeTable.pageNum;
        $('#pageNum').val(num);

        $.each(items.tradeRecord, function(i, item)
        {
            var price = item.price + '万円';
            if (item.price > 10000){
                price = item.price / 10000;
                price += '万円';
            }
            var time_to_station = "";
            if (item.time_to_station !== 0){
                time_to_station = item.time_to_station + "分";
            }
            var row = "";
            row += "<td class=\"textCenter\">" + num + "</td>";
            row += "<td>" + item.type_caption + "</td>";
            row += "<td>" + item.city_name + item.town_name + "</td>";
            row += "<td>" + item.station_name + "</td>";
            row += "<td>" + time_to_station + "</td>";
            row += "<td class=\"textRight\">" + price + "</td>";
            row += "<td class=\"textRight\">" + item.area + "m<sup>2</sup></td>";
            row += "<td>" + item.building_age + "</td>";
            row += "<td>" + item.building_structure + "</td>";
            row += "<td>" + item.land_usage + "</td>";
            row += "<td>" + item.transaction_date + "</td>";

            tableObject.find('tbody').append(
                $('<tr>').append(row)
            );
            num += 1;
        });

        pagerControl(items.pager, items.tradeTable.pageNum);
    }

    function retrieveTradeTableImpl(url)
    {
        $.ajax(
            {
                url: url,
                dataType: 'json',
                type: "GET",
                data: ""
            })
            .then(
                function(res)
                {
                    storeTradeTable(res);
                },
                function()
                {
                    alert('売買実績データの取得に失敗しました');
                });
    }

    function retrieveTradeTable(action)
    {
        var prefectureId = $('#prefectureId').val();
        var cityId = $('#cityId').val();
        var townId = $('#townId').val();
        var stationId = $('#stationId').val();
        var pageNum = $('#pageNum').val();

        var url = '/api/trade/prefecture/' + prefectureId + '/' + pageNum + '/' + action + '/';
        if (cityId > 0){
            url = '/api/trade/city/' + cityId + '/' + pageNum + '/' + action + '/';
        }
        if (townId > 0){
            url = '/api/trade/town/' + townId + '/' + pageNum + '/' + action + '/';
        }
        if (stationId > 0){
            url = '/api/trade/station/' + stationId + '/' + pageNum + '/' + action + '/';
        }
        retrieveTradeTableImpl(url);
    }

    $(document).ready(function()
    {
        retrieveTradeTable('first');
    });

    $('.pageFirst').on('click', function()
    {
        retrieveTradeTable('first');
    });

    $('.pageLast').on('click', function()
    {
        retrieveTradeTable('last');
    });

    $('.pageNext').on('click', function()
    {
        retrieveTradeTable('next');
    });

    $('.pageBefore').on('click', function()
    {
        retrieveTradeTable('prev');
    });

    $('.firstButton').on('click', function()
    {
        var pageNum = $('.firstButton').text();
        pageNum--;
        $('#pageNum').val(pageNum);
        retrieveTradeTable('next');
    });

    $('.secondButton').on('click', function()
    {
        var pageNum = $('.secondButton').text();
        pageNum--;
        $('#pageNum').val(pageNum);
        retrieveTradeTable('next');
    });

    $('.thirdButton').on('click', function()
    {
        var pageNum = $('.thirdButton').text();
        pageNum--;
        $('#pageNum').val(pageNum);
        retrieveTradeTable('next');
    });

    $('.forthButton').on('click', function()
    {
        var pageNum = $('.forthButton').text();
        pageNum--;
        $('#pageNum').val(pageNum);
        retrieveTradeTable('next');
    });

    $('.fifthButton').on('click', function()
    {
        var pageNum = $('.fifthButton').text();
        pageNum--;
        $('#pageNum').val(pageNum);
        retrieveTradeTable('next');
    });

</script>
