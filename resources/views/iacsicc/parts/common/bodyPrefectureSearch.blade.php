@if ($body['weher'] == 'index')
    <section id="prefectureSearch" class="content">
        <div class="areaSelect clearfix">
            <h2 class="areaSelectTitle">都道府県ごとに<br class="sp">査定依頼ができる不動産会社を探す</h2>
            <input type="radio" name="area" id="area1m" class="switch">
            <input type="radio" name="area" id="area2m" class="switch">
            <input type="radio" name="area" id="area3m" class="switch">
            <input type="radio" name="area" id="area4m" class="switch">
            <input type="radio" name="area" id="area5m" class="switch">
            <input type="radio" name="area" id="area6m" class="switch">
            <input type="radio" name="area" id="area7m" class="switch">
            <input type="radio" name="area" id="area8m" class="switch">
            <ul class="areaMap">
                <li class="areaName1"><label class="button" for="area1m">北海道・東北</label>
                    <a href="/hokkaido">北海道</a><a href="/aomori">青森県</a><a href="/iwate">岩手県</a><a href="/miyagi">宮城県</a><a href="/akita">秋田県</a><a href="/yamagata">山形県</a><a href="/fukushima">福島県</a></li>
                <li class="areaName2"><label class="button" for="area2m">関東</label>
                    <a href="/tokyo">東京都</a><a href="/kanagawa">神奈川県</a><a href="/chiba">千葉県</a><a href="/saitama">埼玉県</a><a href="/ibaraki">茨城県</a><a href="/tochigi">栃木県</a><a href="/gunma">群馬県</a></li>
                <li class="areaName3"><label class="button" for="area3m">北陸・甲信越</label>
                    <a href="/yamanashi">山梨県</a><a href="/nagano">長野県</a><a href="/niigata">新潟県</a><a href="/toyama">富山県</a><a href="/ishikawa">石川県</a><a href="/fukui">福井県</a></li>
                <li class="areaName4"><label class="button" for="area4m">東海</label>
                    <a href="/aichi">愛知県</a><a href="/gifu">岐阜県</a><a href="/mie">三重県</a><a href="/shizuoka">静岡県</a></li>
                <li class="areaName5"><label class="button" for="area5m">近畿</label>
                    <a href="/osaka">大阪府</a><a href="/kyoto">京都府</a><a href="/hyogo">兵庫県</a><a href="/nara">奈良県</a><a href="/shiga">滋賀県</a><a href="/wakayama">和歌山県</a></li>
                <li class="areaName6"><label class="button" for="area6m">中国</label>
                    <a href="/tottori">鳥取県</a><a href="/shimane">島根県</a><a href="/okayama">岡山県</a><a href="/hiroshima">広島県</a><a href="/yamaguchi">山口県</a></li>
                <li class="areaName7"><label class="button" for="area7m">四国</label>
                    <a href="/tokushima">徳島県</a><a href="/kagawa">香川県</a><a href="/ehime">愛媛県</a><a href="/kochi">高知県</a></li>
                <li class="areaName8"><label class="button" for="area8m">九州・沖縄</label>
                    <a href="/fukuoka">福岡県</a><a href="/saga">佐賀県</a><a href="/nagasaki">長崎県</a><a href="/kumamoto">熊本県</a><a href="/oita">大分県</a><a href="/miyazaki">宮崎県</a><a href="/kagoshima">鹿児島県</a><a href="/okinawa">沖縄県</a></li>
            </ul>
            <input type="checkbox" name="area2" id="area1t" class="switch">
            <input type="checkbox" name="area2" id="area2t" class="switch">
            <input type="checkbox" name="area2" id="area3t" class="switch">
            <input type="checkbox" name="area2" id="area4t" class="switch">
            <input type="checkbox" name="area2" id="area5t" class="switch">
            <input type="checkbox" name="area2" id="area6t" class="switch">
            <input type="checkbox" name="area2" id="area7t" class="switch">
            <input type="checkbox" name="area2" id="area8t" class="switch">
            <dl class="areaTable">
@else
    <section id="prefList">
        <div class="prefSelect content">
            <h2 class="prefListTitle">都道府県ごとに不動産価格・不動産売買の相場を調べる</h2>
            <dl class="prefTable">
@endif
                <dt id="areaText1"><label class="button" for="area1t">北海道・東北</label></dt>
                <dd id="prefecture1"><a href="/hokkaido">北海道</a><a href="/aomori">青森県</a><a href="/iwate">岩手県</a><a href="/miyagi">宮城県</a><a href="/akita">秋田県</a><a href="/yamagata">山形県</a><a href="/fukushima">福島県</a></dd>
                <dt id="areaText2"><label class="button" for="area2t">関東</label></dt>
                <dd id="prefecture2"><a href="/tokyo">東京都</a><a href="/kanagawa">神奈川県</a><a href="/chiba">千葉県</a><a href="/saitama">埼玉県</a><a href="/ibaraki">茨城県</a><a href="/tochigi">栃木県</a><a href="/gunma">群馬県</a></dd>
                <dt id="areaText3"><label class="button" for="area3t">北陸・甲信越</label></dt>
                <dd id="prefecture3"><a href="/yamanashi">山梨県</a><a href="/nagano">長野県</a><a href="/niigata">新潟県</a><a href="/toyama">富山県</a><a href="/ishikawa">石川県</a><a href="/fukui">福井県</a></dd>
                <dt id="areaText4"><label class="button" for="area4t">東海</label></dt>
                <dd id="prefecture4"><a href="/aichi">愛知県</a><a href="/gifu">岐阜県</a><a href="/mie">三重県</a><a href="/shizuoka">静岡県</a></dd>
                <dt id="areaText5"><label class="button" for="area5t">近畿</label></dt>
                <dd id="prefecture5"><a href="/osaka">大阪府</a><a href="/kyoto">京都府</a><a href="/hyogo">兵庫県</a><a href="/nara">奈良県</a><a href="/shiga">滋賀県</a><a href="/wakayama">和歌山県</a></dd>
                <dt id="areaText6"><label class="button" for="area6t">中国</label></dt>
                <dd id="prefecture6"><a href="/tottori">鳥取県</a><a href="/shimane">島根県</a><a href="/okayama">岡山県</a><a href="/hiroshima">広島県</a><a href="/yamaguchi">山口県</a></dd>
                <dt id="areaText7"><label class="button" for="area7t">四国</label></dt>
                <dd id="prefecture7"><a href="/tokushima">徳島県</a><a href="/kagawa">香川県</a><a href="/ehime">愛媛県</a><a href="/kochi">高知県</a></dd>
                <dt id="areaText8"><label class="button" for="area8t">九州・沖縄</label></dt>
                <dd id="prefecture8"><a href="/fukuoka">福岡県</a><a href="/saga">佐賀県</a><a href="/nagasaki">長崎県</a><a href="/kumamoto">熊本県</a><a href="/oita">大分県</a><a href="/miyazaki">宮崎県</a><a href="/kagoshima">鹿児島県</a><a href="/okinawa">沖縄県</a></dd>
            </dl>
        </div>
    </section>
