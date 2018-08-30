<!-- bodyAreaTrend.blade.php -->
<section class="prg">
    <h2 class="titlePrg bubble">{{$body['areaCaptionOf']}}地価公示価格の傾向</h2>
    <p class="textPrg" id="prefectureDetail">
    </p>
</section>

<script>

    function storePrefectureDetail(details)
    {
        $('#prefectureDetail').html(details);
    }

    function retrievePrefectureDetailSource()
    {
        var prefecture = $('#prefectureAlphabet').val();
        var url = '/api/posted/land/price/prefecture/detail/' + prefecture;
        $.ajax(
            {
                url: url,
                dataType: 'json',
                type: "GET",
                data: ""
            })
            .then(
                function (res) {
                    storePrefectureDetail(res);
                },
                function () {
                    alert('詳細データの取得に失敗しました');
                });
    }

    $(window).on('load', function()
    {
        retrievePrefectureDetailSource();
    });

</script>
