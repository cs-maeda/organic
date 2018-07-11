{if $smarty.const.DEBUG}<!-- {$smarty.current_dir}/{$smarty.template} START -->
{/if}

{if $type != 'index'}
<div class="breadcrumb">
    <div class="inner">
        <ul class=" clearfix">
            {$addr_list = []}
            {$names = $info['header']['desc']['names']}
            <li><a href="/">不動産価格・不動産売買の相場</a></li>
            {while 1}
            {$name = array_shift($names)}
            {$link = array_shift($names)}
            {if $name == ''}
            {break}
            {/if}
            {if $link}
            {$result = array_push($addr_list, $link)}
            <li><a href="/{join("/", $addr_list)}/">{$name}</a></li>
            {else}
            {/if}
            {/while}
            <li class="name">{$info['header']['desc']['name']}</li>
        </ul>
    </div>
</div>
{/if}

<!-- recentPrice -->
<div class="recentPrice">
    <div class="inner">
        <h2 class="recentPriceTitle">直近1年間の{$info['header']['desc']['name']}の不動産売買件数と不動産価格相場（売却件数や平均価格など）</h2>
        <div>
            <dl>
                <dt>{$info['header']['desc']['name']}の不動産売却件数</dt>
                <dd><span class="redTxt">{$records['totalCount']|number_format}</span>件</dd>
            </dl>
            <dl>
                <dt>価格帯</dt>
                <dd><span class="redTxt">{if $records['minPrice'] < 1}{$records['minPrice']}{else}{$records['minPrice']|number_format}{/if}</span>万円～<span class="redTxt">{$records['maxPrice']|number_format}</span>万円</dd>
            </dl>
            <dl>
                <dt>平均価格</dt>
                <dd><span class="redTxt">{$records['avgPrice']|number_format}</span>万円</dd>
            </dl>
        </div>


    </div>
</div>
<!-- recentPrice -->

<!-- priceList -->
<div class="priceList">
    <div class="inner">
        <h2 class="priceListTitle">{$info['header']['desc']['name']}の不動産売却実績・不動産価格一覧</h2>
        <p class="showCount">{$info['header']['max_count']}件中 <span class="start_row">{$info['header']['offset'] + 1}</span>-<span class="end_row">{$info['header']['offset'] + $info['header']['cur_lines']}</span>を表示</p>
        <div id="trading">
            <table class="priceTable" border="0">
                <tr>
                    <th rowspan="2">&nbsp;</th>
                    <th rowspan="2">種類</th>
                    <th rowspan="2">所在地</th>
                    <th colspan="2">最寄駅</th>
                    <th rowspan="2">取引総額</th>
                    <th rowspan="2">面積(m<sup>2</sup>)</th>
                    <th rowspan="2">建築年</th>
                    <th rowspan="2">構造</th>
                    <th rowspan="2">取引時期</th>
                </tr>
                <tr>
                    <th>名称</th>
                    <th>距離(分)</th>
                </tr>
                {$count = 0}
                {foreach $info['body'] as $key => $row}
                <tr class="table_data">
                    {$count = $count + 1}
                    {if $count > 1000}{break}{/if}
                    <td>{$count}</td>
                    <td>{$row['tclass']}</td>
                    <td>{$row['city_name']}</td>
                    <td>{$row['stationname']}</td>
                    <td>{$row['stationtime']}</td>
                    <td>{$row['price1']}</td>
                    <td>面積</td>
                    <td>{$row['year']}</td>
                    <td>{$row['building2']}</td>
                    <td>{$row['time2']}</td>			</tr>
                {/foreach}
            </table>
        </div>


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

    </div>
</div>

{if isset($meta['detail']) && $meta['detail'] != ''}
<div id="area2">
    <section class="content">
        <h2 class="area2Title">{$info['header']['desc']['name']}の<br class="sp">家売却価格の傾向</h2>
        <p class="area2Text">{$meta['detail']}</p>
    </section>
</div>
{/if}
{*<div id="area4">*}
    {*<h2 class="area4Title">{$info['header']['desc']['name']}の<br class="pc1024">家売却相場</h2>*}
    {*<ul class="area4Graph">*}
        {*<li><div class="graphFrame"><h3>1m<sup>2</sup>あたりの単価</h3><p class="graph">{include file = 'parts/area/graph1.tpl'}</p><span class="zoom">拡大</span></div></li>*}
        {*<li><div class="graphFrame"><h3>売却件数推移</h3><p class="graph">{include file = 'parts/area/graph2.tpl'}</p><span class="zoom">拡大</span></div></li>*}
        {*<li><div class="graphFrame"><h3>駅からの距離と売却価格</h3><p class="graph">{include file = 'parts/area/graph3.tpl'}</p><span class="zoom">拡大</span></div></li>*}
        {*</ul>*}
    {*<div id="graphBg">*}
        {*<span class="close">閉じる</span>*}
        {*<p class="graphZoom"></p>*}
        {*</div>*}
    {*</div>*}
{if $type != 'town'}
<!--
<div id="area3" class="content">
	<section class="area3Frame">
		<h2 class="area3Title">{$info['header']['desc']['name']}の不動産価格・不動産売買実績を調べる</h2>
		<ul class="area3List">
			{foreach $info['header']['desc']['list'] as $key => $value}
				<li><a href="./{$key}/">{$value['name']} ({$value['count']})</a></li>
			{/foreach}
		</ul>
	</section>
</div>
-->

<div class="resarchPrice clear">
    <!--  市区町村の不動産価格・不動産売買実績を調べる -->
    <div class="inner first">
        <h2 class="resarchPriceTitle">{$info['header']['desc']['name']}の不動産価格・不動産売買実績を調べる</h2>
        <ul class="">
            {foreach $info['header']['desc']['list'] as $key => $value}
            <li><a href="./{$key}/">{$value['name']} ({$value['count']})</a></li>
            {/foreach}
        </ul>
    </div>
    <!--  市区町村の不動産価格・不動産売買実績を調べる -->

    <!--  ○○駅（○○県○○市）周辺の不動産価格・不動産売買実績を調べる -->
    <div class="inner">
        <h2 class="resarchPriceTitle">{$info['header']['desc']['name']}の不動産価格・不動産売買実績を調べる</h2>
        <ul class="">
            {foreach $info['header']['desc']['list'] as $key => $value}
            <li><a href="./{$key}/">{$value['name']} ({$value['count']})</a></li>
            {/foreach}
        </ul>
    </div>
    <!--  ○○駅（○○県○○市）周辺の不動産価格・不動産売買実績を調べる -->
</div>

<!-- feature -->
<div class="feature">
    <div class="inner">
        <h2 class="featureTitle">{$info['header']['desc']['name']}の不動産価格・不動産売買実績について</h2>
        <p>{$info['header']['desc']['name']}の不動産売買実績データから算出する不動産価格は、直近一年間では、
            {if $records['minPrice'] < 1}{$records['minPrice']}{else}{$records['minPrice']|number_format}{/if}
            万円～
            {$records['maxPrice']|number_format}
            万円の価格帯となっており、平均価格は
            {$records['maxPrice']|number_format}
            万円です。<br>
            日本全体の平均と比べると、{$info['header']['desc']['name']}の不動産価格の平均は
            {$records['maxPrice']|number_format}
            倍になり、{$info['header']['desc']['name']}は全国で
            {$records['maxPrice']|number_format}
            位となっています。<br>
            なお、当サイトに掲載しているデータは、国交省が公開している土地総合情報システムの{$info['header']['desc']['name']}の不動産売買実績データに基づいており、不動産取引の当事者に対して国交省が実施しているアンケート調査の結果が元となっています。<br>
            数値の丸め以外の補正は一切行われていませんが、不動産価格は個別の事情で大きく変わるため、不動産価格を知りたい方は不動産会社に査定依頼をすることをお勧めします。<br>
            当サイトでは、{$info['header']['desc']['name']}の不動産価格に詳しく、不動産売買実績も豊富な不動産会社に無料で査定依頼ができる窓口もご用意しておりますので、是非ご活用ください。

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
            <li class="kanto"><a href="ibaraki">茨城県</a></li>
            <li class="kanto"><a href="tochigi">栃木県</a></li>
            <li class="kanto"><a href="gunma">群馬県</a></li>
            <li class="kanto"><a href="saitama">埼玉県</a></li>
            <li class="kanto"><a href="chiba">千葉県</a></li>
            <li class="kanto"><a href="tokyo">東京都</a></li>
            <li class="kanto"><a href="kanagawa">神奈川県</a></li>
        </ul>
        <ul class="hokuriku">
            <li><a href="yamanashi">山梨県</a></li>
            <li><a href="nagano">長野県</a></li>
            <li><a href="niigata">新潟県</a></li>
            <li><a href="toyama">富山県</a></li>
            <li><a href="ishikawa">石川県</a></li>
            <li><a href="fukui">福井県</a></li>
        </ul>
        <ul class="tokai">
            <li><a href="aichi">愛知県</a></li>
            <li><a href="gifu">岐阜県</a></li>
            <li><a href="mie">三重県</a></li>
            <li><a href="shizuoka">静岡県</a></li>
        </ul>
        <ul class="kinki">
            <li><a href="osaka">大阪府</a></li>
            <li><a href="kyoto">京都府</a></li>
            <li><a href="hyogo">兵庫県</a></li>
            <li><a href="nara">奈良県</a></li>
            <li><a href="shiga">滋賀県</a></li>
            <li><a href="wakayama">和歌山県</a></li>
        </ul>
        <ul class="chugoku">
            <li><a href="tottori">鳥取県</a></li>
            <li><a href="shimane">島根県</a></li>
            <li><a href="okayama">岡山県</a></li>
            <li><a href="hiroshima">広島県</a></li>
            <li><a href="yamaguchi">山口県</a></li>
        </ul>
        <ul class="shikoku">
            <li><a href="tokushima">徳島県</a></li>
            <li><a href="kagawa">香川県</a></li>
            <li><a href="ehime">愛媛県</a></li>
            <li><a href="kochi">高知県</a></li>
        </ul>
        <ul class="kyushu">
            <li><a href="fukuoka">福岡県</a></li>
            <li><a href="saga">佐賀県</a></li>
            <li><a href="nagasaki">長崎県</a></li>
            <li><a href="kumamoto">熊本県</a></li>
            <li><a href="oita">大分県</a></li>
            <li><a href="miyazaki">宮崎県</a></li>
            <li><a href="kagoshima">鹿児島県</a></li>
            <li><a href="okinawa">沖縄県</a></li>
        </ul>
    </div>
</div>
<!-- prefectureLink -->
{/if}
{if $smarty.const.DEBUG}<!-- {$smarty.current_dir}/{$smarty.template} END -->
{/if}
