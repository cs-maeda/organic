<div class="breadcrumb">
    <div class="inner">
        <ul class=" clearfix">
            <li><a href="/">{{$body['areaCaptionOf']}}不動産価格・不動産売買の相場</a></li>
            <li class="name">{{$body['areaCaption']}}</li>
        </ul>
    </div>
</div>

<!-- recentPrice -->
<div class="recentPrice">
    <div class="inner">
        <h2 class="recentPriceTitle">直近5年間の{{$body['areaCaptionOf']}}不動産売買件数と不動産価格相場（売却件数や平均価格など）</h2>
        <div>
            <dl>
                <dt>{{$body['areaCaptionOf']}}不動産売却件数</dt>
                <dd><span class="redTxt">「-売却件数-」</span>件</dd>
            </dl>
            <dl>
                <dt>価格帯</dt>
                <dd><span class="redTxt">「-最低価格-」</span>万円～<span class="redTxt">〇〇</span>万円</dd>
            </dl>
            <dl>
                <dt>平均価格</dt>
                <dd><span class="redTxt">「-平均価格-」</span>万円</dd>
            </dl>
        </div>
    </div>
</div>
<!-- recentPrice -->

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
            --}}直近一年間では、〇〇万円{{--
            --}}～〇〇万円の価格帯となっており、{{--
            --}}平均価格は〇〇万円です。〇〇の平均と比べると、〇〇の不動産価格の{{--
            --}}平均は〇〇倍になり、{{--
            --}}〇〇は〇〇で〇〇位となっています。なお、当サイトに掲載しているデータは、{{--
            --}}国交省が公開している土地総合情報システムの〇〇の不動産売買実績データに基づいており、{{--
            --}}不動産取引の当事者に対して国交省が実施しているアンケート調査の結果が元となっています。{{--
            --}}数値の丸め以外の補正は一切行われていませんが、不動産価格は個別の事情で大きく変わるため、{{--
            --}}不動産価格を知りたい方は不動産会社に査定依頼をすることをお勧めします。当サイトでは、〇〇の不動産価格に詳しく、{{--
            --}}不動産売買実績も豊富な不動産会社に無料で査定依頼ができる窓口もご用意しておりますので、是非ご活用ください。
        </p>
    </div>
</div><!-- feature -->


<!-- prefectureLink -->
<div class="prefectureLink">
    <div class="inner">
        <h2 class="prefectureLinktitle">都道府県ごとに不動産価格・不動産売買の相場を調べる</h2>
        <ul class="tohoku">
            <li class="tohoku"><a href="/hokkaido">北海道</a</li>
            <li class="tohoku"><a href="/aomori">青森県</a></li>
            <li class="tohoku"><a href="/iwate">岩手県</a></li>
            <li class="tohoku"><a href="/miyagi">宮城県</a></li>
            <li class="tohoku"><a href="/akita">秋田県</a></li>
            <li class="tohoku"><a href="/yamagata">山形県</a></li>
            <li class="tohoku"><a href="/fukushima">福島県</a></li>
        </ul>
        <ul class="kanto">
            <li class="kanto"><a href="/ibaraki">茨城県</a></li>
            <li class="kanto"><a href="/tochigi">栃木県</a></li>
            <li class="kanto"><a href="/gunma">群馬県</a></li>
            <li class="kanto"><a href="/saitama">埼玉県</a></li>
            <li class="kanto"><a href="/chiba">千葉県</a></li>
            <li class="kanto"><a href="/tokyo">東京都</a></li>
            <li class="kanto"><a href="/kanagawa">神奈川県</a></li>
        </ul>
        <ul class="hokuriku">
            <li><a href="/yamanashi">山梨県</a></li>
            <li><a href="/nagano">長野県</a></li>
            <li><a href="/niigata">新潟県</a></li>
            <li><a href="/toyama">富山県</a></li>
            <li><a href="/ishikawa">石川県</a></li>
            <li><a href="/fukui">福井県</a></li>
        </ul>
        <ul class="tokai">
            <li><a href="/aichi">愛知県</a></li>
            <li><a href="/gifu">岐阜県</a></li>
            <li><a href="/mie">三重県</a></li>
            <li><a href="/shizuoka">静岡県</a></li>
        </ul>
        <ul class="kinki">
            <li><a href="/osaka">大阪府</a></li>
            <li><a href="/kyoto">京都府</a></li>
            <li><a href="/hyogo">兵庫県</a></li>
            <li><a href="/nara">奈良県</a></li>
            <li><a href="/shiga">滋賀県</a></li>
            <li><a href="/wakayama">和歌山県</a></li>
        </ul>
        <ul class="chugoku">
            <li><a href="/tottori">鳥取県</a></li>
            <li><a href="/shimane">島根県</a></li>
            <li><a href="/okayama">岡山県</a></li>
            <li><a href="/hiroshima">広島県</a></li>
            <li><a href="/yamaguchi">山口県</a></li>
        </ul>
        <ul class="shikoku">
            <li><a href="/tokushima">徳島県</a></li>
            <li><a href="/kagawa">香川県</a></li>
            <li><a href="/ehime">愛媛県</a></li>
            <li><a href="/kochi">高知県</a></li>
        </ul>
        <ul class="kyushu">
            <li><a href="/fukuoka">福岡県</a></li>
            <li><a href="/saga">佐賀県</a></li>
            <li><a href="/nagasaki">長崎県</a></li>
            <li><a href="/kumamoto">熊本県</a></li>
            <li><a href="/oita">大分県</a></li>
            <li><a href="/miyazaki">宮崎県</a></li>
            <li><a href="/kagoshima">鹿児島県</a></li>
            <li><a href="/okinawa">沖縄県</a></li>
        </ul>
    </div>
</div>
