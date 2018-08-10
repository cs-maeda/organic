<footer class="pageFoot">
    <div class="inner">
        <ul class="footerMenu">
            @foreach($body['eachLink'] as $link)
            <li><a href="{{$link['link']}}" target="_blank">{{$link['caption']}}</a></li>
            @endforeach
        </ul>
    </div>
</footer>

<p class="pageTop">
    <span class="button"><img src="/images/pageTop.png" alt="ページトップへ" class="width100"></span>
</p>


