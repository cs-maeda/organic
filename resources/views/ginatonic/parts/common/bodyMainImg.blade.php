<div class="mainV">
    <div class="inner">
        <img src="/images/ginatonic/img_banner_pd.jpg" alt="地価公示価格と売却価格" class="width100 pd">
        <div class="text">
            <h2 class="mainVtitle wf-mplus1p">
                @if ($body['where'] == 'index')
                    あなたの土地の評価額はいくら？
                @else
                    {{$body['copy'][0]}}
                @endif
            </h2>
            <p class="mainVsubtitle">{{$body['copy'][1]}}</p>
        </div>
    </div>
</div>

