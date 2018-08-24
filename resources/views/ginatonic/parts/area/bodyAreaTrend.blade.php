<!-- bodyAreaTrend.blade.php -->
<section class="prg">
    <h2 class="titlePrg bubble">{{$body['areaCaptionOf']}}地価公示価格の傾向</h2>
    <p class="textPrg" id="prefectureDetail">
    </p>
</section>

<script>

    function storeAreaDetail(details)
    {
        $('#prefectureDetail').html(details);
    }

    function retrieveAreaDetailSource()
    {
        var prefectureId = $('#prefectureId').val();
        var url = '/api/posted/land/price/prefecture/detail/' + prefectureId;
        $.ajax(
            {
                url: url,
                dataType: 'json',
                type: "GET",
                data: ""
            })
            .then(
                function (res) {
                    storeAreaDetail(res);
                },
                function () {
                    alert('詳細データの取得に失敗しました');
                });
    }

    $(window).on('load', function()
    {
        retrieveAreaDetailSource();
    });

</script>
