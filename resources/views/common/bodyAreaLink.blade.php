<div class="areaLink">
    @isset($body['areaLink']['city'])
        <!--  市区町村の不動産価格・不動産売買実績を調べる -->
        <div class="inner second city">
            <h2 class="areaLinktitle">{{$body['areaCaption']}}の{{$body['subject']}}実績を調べる</h2>
            <ul class="areaList">
                @foreach($body['areaLink']['city'] as $city)
                    @if ($city['link'] == '')
                        <li>{{$city['caption']}}</li>
                    @else
                        <li><a href="{{$city['link']}}">{{$city['caption']}}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endisset
</div>
