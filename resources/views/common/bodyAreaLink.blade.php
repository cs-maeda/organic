<div class="areaLink">
    @isset($body['areaLink']['city'])
        <!--  市区町村の不動産価格・不動産売買実績を調べる -->
        <div class="inner second">
            <h2 class="areaLinktitle">{{$body['areaCaption']}}の不動産価格・不動産売買実績を調べる</h2>
            <ul class="areaList">
                @foreach($body['areaLink']['city'] as $city)
                    <li><a href="{{$city['link']}}">{{$city['caption']}}</a></li>
                @endforeach
            </ul>
        </div>
    @endisset

    @isset($body['areaLink']['town'])
        <!--  町域の不動産価格・不動産売買実績を調べる -->
        <div class="inner second">
            <h2 class="areaLinktitle">{{$body['areaCaption']}}の不動産価格・不動産売買実績を調べる</h2>
            <ul class="areaList">
                @foreach($body['areaLink']['town'] as $town)
                    <li><a href="{{$town['link']}}">{{$town['caption']}}</a></li>
                @endforeach
            </ul>
        </div>
    @endisset

    @isset($body['areaLink']['station'])
        <!--  ○○駅（○○県○○市）周辺の不動産価格・不動産売買実績を調べる -->
        <div class="inner second">
            <h2 class="areaLinktitle">{{$body['areaCaptionOf']}}の駅周辺の不動産価格・不動産売買実績を調べる</h2>
            <ul class="areaList">
                @foreach($body['areaLink']['station'] as $station)
                    <li><a href="{{$station['link']}}">{{$station['caption']}}</a></li>
                @endforeach
            </ul>
        </div>
    @endisset
</div>
