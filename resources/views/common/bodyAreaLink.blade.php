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

    @isset($body['areaLink']['town'])
        <!--  町域の不動産価格・不動産売買実績を調べる -->
        <div class="inner second town">
            <h2 class="areaLinktitle">{{$body['areaCaption']}}周辺の{{$body['subject']}}実績を調べる</h2>
            <ul class="areaList">
                @foreach($body['areaLink']['town'] as $town)
                    @if ($town['link'] == '')
                        <li>{{$town['caption']}}</li>
                    @else
                        <li><a href="{{$town['link']}}">{{$town['caption']}}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endisset

    @isset($body['areaLink']['station'])
        <!--  ○○駅（○○県○○市）周辺の不動産価格・不動産売買実績を調べる -->
        <div class="inner second station">
            <h2 class="areaLinktitle">{{$body['areaCaptionOf']}}駅周辺の{{$body['subject']}}実績を調べる</h2>
            <ul class="areaList">
                @foreach($body['areaLink']['station'] as $station)
                    @if ($station['link'] == '')
                        <li>{{$station['caption']}}</li>
                    @else
                        <li><a href="{{$station['link']}}">{{$station['caption']}}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endisset
</div>
