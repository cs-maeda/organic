<!-- bodyAverageGraph.blade.php -->
<section class="prg averageGraph">
    <h2 class="titlePrg cal">{{$body['areaCaptionOf']}}地価公示価格平均推移</h2>
    <p>{{$body['areaCaption']}}全体の地価公示価格と日本全体の地価公示価格の平均値を比較したグラフです</p>
    <div>
        <canvas id="areaCharts" width=“300px” height=“200px”></canvas>
    </div>
    <p class="remark">※地価平均は全地点の公示価格平均値を算出、上昇率は新規測定地を除いた公示地点の平均上昇率</p>
</section>
<script>

    function storeAreaGraph(averages)
    {
        var areaCaptionOf = $('#areaCaptionOf').val();
        var japanData = [];
        var areaData = [];
        var subjects = [];
        $.each(averages.japan, function(year, value)
        {
            japanData.push(value);
            subjects.push(year);
        });
        $.each(averages.area, function(year, value)
        {
            areaData.push(value);
        });

        var ctx = document.getElementById("areaCharts").getContext('2d');
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
                        label: areaCaptionOf + "地価公示価格の推移",
                        //面の表示
                        fill: false,
                        //線のカーブ
                        lineTension: 0,
                        // //背景色
                        // backgroundColor: "rgba(179,181,198,0.2)",
                        //枠線の色
                        borderColor: "rgba(120,120,90,1)",
                        //結合点の枠線の色
                        pointBorderColor: "rgba(120,120,98,1)",
                        // //結合点の背景色
                        // pointBackgroundColor: "#fff",
                        //結合点のサイズ
                        pointRadius: 5,
                        // //結合点のサイズ（ホバーしたとき）
                        // pointHoverRadius: 8,
                        // //結合点の背景色（ホバーしたとき）
                        // pointHoverBackgroundColor: "rgba(179,181,198,1)",
                        //結合点の枠線の色（ホバーしたとき）
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        // //結合点より外でマウスホバーを認識する範囲（ピクセル単位）
                        // pointHitRadius: 15,
                        //グラフのデータ
                        data: areaData
                    },
                    {
                        //凡例
                        label: "日本全体の地価公示価格の推移",
                        //面の表示
                        fill: false,
                        //線のカーブ
                        lineTension: 0,
                        // //背景色
                        // backgroundColor: "rgba(179,181,198,0.2)",
                        //枠線の色
                        borderColor: "rgba(179,181,198,1)",
                        //結合点の枠線の色
                        pointBorderColor: "rgba(179,181,198,1)",
                        // //結合点の背景色
                        // pointBackgroundColor: "#fff",
                        //結合点のサイズ
                        pointRadius: 5,
                        // //結合点のサイズ（ホバーしたとき）
                        // pointHoverRadius: 8,
                        // //結合点の背景色（ホバーしたとき）
                        // pointHoverBackgroundColor: "rgba(179,181,198,1)",
                        //結合点の枠線の色（ホバーしたとき）
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        // //結合点より外でマウスホバーを認識する範囲（ピクセル単位）
                        // pointHitRadius: 15,
                        //グラフのデータ
                        data: japanData
                    }
                ]
            },
            options: {
                animation: false,
                tooltips: {
                    enabled: false
                }
            }
        });
    }

    function retrieveAreaGraphSource()
    {
        var prefectureId = $('#prefectureId').val();
        var cityId = $('#cityId').val();
        var areaId = prefectureId;
        if ((cityId != null)&&(cityId > 0)){
            areaId = cityId;
        }
        var url = '/api/posted/land/price/average/' + areaId;
        $.ajax(
            {
                url: url,
                dataType: 'json',
                type: "GET",
                data: ""
            })
            .then(
                function (res) {
                    storeAreaGraph(res);
                },
                function () {
                    alert('グラフデータの取得に失敗しました');
                });
    }

    $(window).on('load', function()
    {
        retrieveAreaGraphSource();
    });



</script>
