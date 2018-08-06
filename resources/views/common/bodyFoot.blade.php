<footer class="pageFoot">
    <div class="inner">
        <ul class="footerMenu">
            @foreach($body['eachLink'] as $link)
            <li><a href="{{$link['link']}}">{{$link['caption']}}</a></li>
            @endforeach
        </ul>
    </div>
</footer>

<p class="pageTop">
    <span class="button"><img src="/images/pageTop.png" alt="ページトップへ" class="width100"></span>
</p>

<!-- Global site tag (gtag.js) - Google Analytics START -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112538056-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-112538056-1');
</script>
<!-- Global site tag (gtag.js) - Google Analytics END -->

