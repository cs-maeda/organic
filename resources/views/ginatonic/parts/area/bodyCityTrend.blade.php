<!-- bodyAreaTrend.blade.php -->
<section class="prg">
    <h2 class="titlePrg bubble">{{$body['areaCaptionOf']}}地価公示価格の傾向</h2>
    <p class="textPrg" id="cityDetail">
    </p>
</section>

<script>

    function storeCityDetail(details)
    {
        $('#cityDetail').html(details);
    }

    function retrieveCityDetailSource()
    {
        var prefecture = $('#prefectureAlphabet').val();
        var city = $('#cityAlphabet').val();
        var url = '/api/posted/land/price/city/detail/' + prefecture + '/' + city;
        $.ajax(
            {
                url: url,
                dataType: 'json',
                type: "GET",
                data: ""
            })
            .then(
                function (res) {
                    storeCityDetail(res);
                },
                function () {
                    $('#cityDetail').hide();
                });
    }

    $(window).on('load', function()
    {
        retrieveCityDetailSource();
    });

</script>
