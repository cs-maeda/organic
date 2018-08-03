
<div class="recentPrice">
    <div class="inner">
        <h2 class="recentPriceTitle">直近５年間の{{$body['areaCaptionOf']}}土地売買件数と土地価格相場</h2>
        <ul class="recentPriceList">
            <li class="count">
                <h3>{{$body['areaCaptionOf']}}土地売却件数</h3>
                <p><span class="orange">{{number_format($body['figure']['own']['trade_count'])}}</span>件</p>
            </li>
            <li class="lowPrice">
                <h3>価格帯</h3>
                <p><span class="orange">@if ($body['figure']['own']['min_price'] < 10000){{number_format($body['figure']['own']['min_price'] / 10000, 2)}}@else{{number_format($body['figure']['own']['min_price'] / 10000)}}@endif</span>万円～
                    <span class="orange">{{number_format($body['figure']['own']['max_price'] / 10000)}}</span>万円</p>
            </li>
            <li class="highPrice">
                <h3>平均価格</h3>
                <p><span class="orange">{{number_format($body['figure']['own']['avg_price'] / 10000)}}</span>万円</p>
            </li>
        </ul>
    </div>
    <div class="inner trade">
        {{--売買実績テーブル--}}
        <h2 class="recentPriceTitle">{{$body['areaCaptionOf']}}土地売却実績・土地価格一覧</h2>
        @include('common/bodyTradeTable')
    </div>
</div>

@include('common.bodyAreaLink')

<!-- feature -->
<div class="feature">
    <div class="inner">
        <h2 class="featureTitle">{{$body['areaCaptionOf']}}土地価格・土地売買実績について</h2>
        <?php $parent = '日本全体'?>
        <?php $parentAll = '全国'?>
        <p>
            {{$body['areaCaptionOf']}}土地売買実績データから算出する土地価格は、{{--
            --}}直近５年間では、{{number_format($body['figure']['own']['min_price'] / 10000, 2)}}万円{{--
            --}}～{{number_format($body['figure']['own']['max_price'] / 10000)}}万円の価格帯となっており、{{--
            --}}平均価格は{{number_format($body['figure']['own']['avg_price'] / 10000)}}万円です。{{$body['parentAreaCaption']}}の平均と比べると、{{--
            --}}{{$body['areaCaption']}}の土地価格の平均は{{number_format($body['figure']['own']['avg_price'] / $body['figure']['parent']['avg_price'], 2)}}倍になり、{{--
            --}}{{$body['areaCaption']}}は{{$body['parentAreaCaption']}}で{{$body['figure']['own']['ranking']}}位となっています。なお、当サイトに掲載しているデータは、{{--
            --}}国交省が公開している土地総合情報システムの{{$body['areaCaption']}}の土地売買実績データに基づいており、{{--
            --}}土地取引の当事者に対して国交省が実施しているアンケート調査の結果が元となっています。{{--
            --}}数値の丸め以外の補正は一切行われていませんが、土地価格は個別の事情で大きく変わるため、{{--
            --}}土地価格を知りたい方は不動産会社に査定依頼をすることをお勧めします。当サイトでは、{{$body['areaCaption']}}の土地価格に詳しく、{{--
            --}}土地売買実績も豊富な不動産会社に無料で査定依頼ができる窓口もご用意しておりますので、是非ご活用ください。
        </p>
    </div>
</div><!-- feature -->

