<!-- priceList -->
<h2 class="recentPriceTitle">{{$body['areaCaptionOf']}}不動産売却実績・不動産価格一覧</h2>
<p class="showCount">〇〇件中 <span class="start_row">〇〇</span>-<span class="end_row">〇〇</span>を表示</p>
<div id="trading">
    <table class="priceTable" border="0">
        <thead>
            <tr>
                <th rowspan="2">&nbsp;</th>
                <th rowspan="2">種類</th>
                <th rowspan="2">所在地</th>
                <th colspan="2">最寄駅</th>
                <th rowspan="2">取引総額</th>
                <th rowspan="2">面積(m<sup>2</sup>)</th>
                <th rowspan="2">建築年</th>
                <th rowspan="2">構造</th>
                <th rowspan="2">用途</th>
                <th rowspan="2">取引時期</th>
            </tr>
            <tr>
                <th>名称</th>
                <th>距離(分)</th>
            </tr>
        </thead>
        <tbody id="tradeRecords">
            <tr>
                <td class="textCenter">1</td>
                <td>宅地(土地と建物)</td>
                <td>札幌市中央区</td>
                <td>西２８丁目</td>
                <td>14分</td>
                <td class="textRight">3,200万円</td>
                <td class="textRight">340m<sup>2</sup></td>
                <td>昭和32年</td>
                <td>木造</td>
                <td>共同住宅</td>
                <td>H29/04-06月</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="pager">
    <ul class="pagerList">
        <li class="arrow pageFirst end">&lt;&lt;</li>
        <li class="arrow pageBefore">&lt;</li>
        <li class="current">1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
        <li>5</li>
        <li class="arrow pageNext">&gt;</li>
        <li class="arrow pageLast end pc">&gt;&gt;</li>
    </ul>
</div>

{{--
{if $info['header']['last_page'] != 1}
<div class="pager">
    <ul>
        <li class="top pc"><span class="arrow pagerElem" id="top_page_{$info['header']['first_page']}">&lt;&lt;</span></li>
        <li class="before"><span class="arrow pageBefore pagerElem" id="before_page_{$info['header']['prev_page']}">&lt;</span></li>
        {foreach range($info['header']['tab_start'], $info['header']['tab_end']) as $count}
        {if $info['header']['cur_page'] == $count}
        <li class="current pageBox pagerElem" id="curBox_page_{$count}">{$count}</li>
        {else}
        <li class="pageBox pagerElem" id="curBox_page_{$count}">{$count}</li>
        {/if}
        {/foreach}
        <li class="after"><span class="arrow pagerElem" id="after_page_{$info['header']['next_page']}">&gt;</span></li>
        <li class="last pc"><span class="arrow pagerElem" id="last_page_{$info['header']['last_page']}">&gt;&gt;</span></li>
    </ul>
</div>
{/if}
--}}
