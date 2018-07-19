
<div class="recentPrice">
    <div class="inner">
        <h2 class="recentPriceTitle">直近5年間の{{$body['areaCaptionOf']}}不動産売買件数と不動産価格相場（売却件数や平均価格など）</h2>
        <ul class="recentPriceList">
            <li class="count">
                <h3>{{$body['areaCaptionOf']}}不動産売却件数</h3>
                <p><span class="red">{{number_format($body['figure']['count'])}}</span>件</p>
            </li>
            <li class="lowPrice">
                <h3>価格帯</h3>
                <p><span class="red">{{number_format($body['figure']['min_price'] / 10000, 2)}}</span>万円～<span class="red">{{number_format($body['figure']['max_price'] / 10000)}}</span>万円</p>
            </li>
            <li class="highPrice">
                <h3>平均価格</h3>
                <p><span class="red">{{number_format($body['figure']['avg_price'] / 10000)}}</span>万円</p>
            </li>
        </ul>
    </div>
</div>

{{--売買実績テーブル--}}
@include('common/bodyTradeTable')

<div class="resarchPrice clear">
    <!--  市区町村の不動産価格・不動産売買実績を調べる -->
    <div class="inner first">
        {{--<h2 class="resarchPriceTitle">〇〇@if ($body['where'] == 'town')||($body['where'] == 'station')周辺@endifの不動産価格・不動産売買実績を調べる</h2>--}}
        <h2 class="resarchPriceTitle">{{$body['areaCaption']}}周辺の不動産価格・不動産売買実績を調べる</h2>
        <ul class="">
            {{--{foreach $info['header']['desc']['list'] as $key => $value}--}}
            {{--<li><a href="{$value['link']}">{$value['name']} ({$value['count']})</a></li>--}}
            {{--{/foreach}--}}
        </ul>
    </div>
    <!--  市区町村の不動産価格・不動産売買実績を調べる -->

    @if ($body['where'] != 'prefecture')
        <!--  ○○駅（○○県○○市）周辺の不動産価格・不動産売買実績を調べる -->
        <div class="inner">
            <h2 class="resarchPriceTitle">{{$body['areaCaptionOf']}}の駅周辺の不動産価格・不動産売買実績を調べる</h2>
            <ul class="">
                {{--{foreach $info['header']['desc']['stationList'] as $key => $value}--}}
                {{--{if $type == 'city'}--}}
                {{--<li><a href="./station/{$key}/">{$value['name']}駅&nbsp;({$value['count']})</a></li>--}}
                {{--{else}--}}
                {{--<li><a href="{$value['link']}">{$value['name']}駅&nbsp;({$value['count']})</a></li>--}}
                {{--{/if}--}}
                {{--{/foreach}--}}
            </ul>
        </div>
    <!--  ○○駅（○○県○○市）周辺の不動産価格・不動産売買実績を調べる -->
    @endif
</div>

<!-- feature -->
<div class="feature">
    <div class="inner">
        <h2 class="featureTitle">{{$body['areaCaptionOf']}}不動産価格・不動産売買実績について</h2>
        <?php $parent = '日本全体'?>
        <?php $parentAll = '全国'?>
        <p>
            {{$body['areaCaptionOf']}}不動産売買実績データから算出する不動産価格は、{{--
            --}}直近５年間では、{{number_format($body['figure']['min_price'] / 10000, 2)}}万円{{--
            --}}～{{number_format($body['figure']['max_price'] / 10000)}}万円の価格帯となっており、{{--
            --}}平均価格は{{number_format($body['figure']['avg_price'] / 10000)}}万円です。{{$body['parentAreaCaption']}}の平均と比べると、{{--
            --}}{{$body['areaCaption']}}の不動産価格の平均は〇〇倍になり、{{--
            --}}{{$body['areaCaption']}}は{{$body['parentAreaCaption']}}で〇〇位となっています。なお、当サイトに掲載しているデータは、{{--
            --}}国交省が公開している土地総合情報システムの{{$body['areaCaption']}}の不動産売買実績データに基づいており、{{--
            --}}不動産取引の当事者に対して国交省が実施しているアンケート調査の結果が元となっています。{{--
            --}}数値の丸め以外の補正は一切行われていませんが、不動産価格は個別の事情で大きく変わるため、{{--
            --}}不動産価格を知りたい方は不動産会社に査定依頼をすることをお勧めします。当サイトでは、{{$body['areaCaption']}}の不動産価格に詳しく、{{--
            --}}不動産売買実績も豊富な不動産会社に無料で査定依頼ができる窓口もご用意しておりますので、是非ご活用ください。
        </p>
    </div>
</div><!-- feature -->

