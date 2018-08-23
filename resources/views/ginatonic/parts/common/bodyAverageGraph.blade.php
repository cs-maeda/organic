<!-- bodyAverageGraph.blade.php -->
<section class="prg averageGraph">
    <h2 class="titlePrg cal">@if ($body['where'] == 'index')日本全体の@else{{$body['areaCaptionOf']}}@endif地価公示価格平均推移</h2>
    @if ($body['where'] != 'index')<p>{{$body['areaCaption']}}全体の地価公示価格と日本全体の地価公示価格の平均値を比較したグラフです</p>@endif
    <div class="graphArea">
        <canvas id="indexCharts" width=“300px” height=“200px”></canvas>
        <p class="remark">※地価平均は全地点の公示価格平均値を算出、上昇率は新規測定地を除いた公示地点の平均上昇率</p>
    </div>
</section>
<script>

    function storeIndexGraph(averages)
    {
        var data = [];
        var subjects = [];
        $.each(averages, function(year, value)
        {
            data.push(value);
            subjects.push(year);
        });

        var ctx = document.getElementById("indexCharts").getContext('2d');
        ctx.canvas.height = 100;
        var myChart = new Chart(ctx, {
            //グラフの種類
            type: 'line',
            //データの設定
            data: {
                //データ項目のラベル
                labels: subjects,
                //データセット
                datasets: [
                    {
                        //凡例
                        label: "日本全体の地価公示価格平均",
                        //面の表示
                        fill: false,
                        //線のカーブ
                        lineTension: 0,
                        // //背景色
                        backgroundColor: "rgba(255,255,255,1.0)",
                        //枠線の色
                        borderColor: "rgba(56,153,195,1.0)",
                        //結合点の枠線の色
                        pointBorderColor: "rgba(56,153,195,1.0)",
                        // //結合点の背景色
                        pointBackgroundColor: "#ffffff",
                        //結合点のサイズ
                        pointRadius: 4,
                        // //結合点のサイズ（ホバーしたとき）
                        // pointHoverRadius: 8,
                        // //結合点の背景色（ホバーしたとき）
                        // pointHoverBackgroundColor: "rgba(179,181,198,1)",
                        //結合点の枠線の色（ホバーしたとき）
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        // //結合点より外でマウスホバーを認識する範囲（ピクセル単位）
                        // pointHitRadius: 15,
                        //グラフのデータ
                        data: data,
                    }
                ]
            },
            options: {
            }
        });
    }

    function retrieveIndexGraphSource(url)
    {
        $.ajax(
            {
                url: '/api/posted/land/price/average/0/',
                dataType: 'json',
                type: "GET",
                data: ""
            })
            .then(
                function (res) {
                    storeIndexGraph(res);
                },
                function () {
                    alert('グラフデータの取得に失敗しました');
                });
    }

    $(window).on('load', function()
    {
        retrieveIndexGraphSource();
    });



</script>
