<div class="form_0{{$idNo}}">
    <div class="formArea">
        <div class="inner">
            <form id="form_{{$idNo}}" method="post" action="https://www.sumaistar.<?php
				if (preg_replace('/^.+\.([^\.]+)$/', '$1', $_SERVER['HTTP_HOST']) == 'dev') {
					print 'dev';
				} else {
					print 'com';
				} ?>/drive/form/sell/" class="form">
                <ul class="lpForm clearfix">
                    <li class="st1">
                        <span class="formStep">
                            <select id="objectType_{{$idNo}}" class="objectType" name="objectType">
                                <option value="">物件種別を選択</option>
                                <option value="10">分譲マンション</option>
                                <option value="11">一戸建て</option>
                                <option value="12">土地</option>
                                <option value="14">一棟アパート･一棟マンション</option>
                                <option value="15">投資マンション(１Ｒ･１Ｋ)</option>
                                <option value="16">一棟ビル</option>
                                <option value="17">区分所有ビル（ビル１室）</option>
                                <option value="20">店舗･工場･倉庫</option>
                                <option value="21">農地</option>
                                <option value="13">その他</option>
                            </select>
                        </span>
                    </li>
                    <li class="st2">
                        <span class="formStep">
                            <select id="objectPrefecture_{{$idNo}}" class="objectPrefecture" name="objectPrefecture">
                                <option value="0">都道府県を選択</option>
								<optgroup label="北海道">
									<option value="1">北海道</option>
								</optgroup>
								<optgroup label="東北">
									<option value="2">青森県</option>
									<option value="3">岩手県</option>
									<option value="4">宮城県</option>
									<option value="5">秋田県</option>
									<option value="6">山形県</option>
									<option value="7">福島県</option>
								</optgroup>
								<optgroup label="関東">
									<option value="13">東京都</option>
									<option value="14">神奈川県</option>
									<option value="12">千葉県</option>
									<option value="11">埼玉県</option>
									<option value="8">茨城県</option>
									<option value="9">栃木県</option>
									<option value="10">群馬県</option>
								</optgroup>
								<optgroup label="甲信越">
									<option value="15">新潟県</option>
									<option value="19">山梨県</option>
									<option value="20">長野県</option>
								</optgroup>
								<optgroup label="北陸">
									<option value="16">富山県</option>
									<option value="17">石川県</option>
									<option value="18">福井県</option>
								</optgroup>
								<optgroup label="東海">
									<option value="23">愛知県</option>
									<option value="22">静岡県</option>
									<option value="21">岐阜県</option>
								</optgroup>
								<optgroup label="近畿">
									<option value="27">大阪府</option>
									<option value="28">兵庫県</option>
									<option value="26">京都府</option>
									<option value="29">奈良県</option>
									<option value="24">三重県</option>
									<option value="25">滋賀県</option>
									<option value="30">和歌山県</option>
								</optgroup>
								<optgroup label="中国">
									<option value="31">鳥取県</option>
									<option value="32">島根県</option>
									<option value="33">岡山県</option>
									<option value="34">広島県</option>
									<option value="35">山口県</option>
								</optgroup>
								<optgroup label="四国">
									<option value="36">徳島県</option>
									<option value="37">香川県</option>
									<option value="38">愛媛県</option>
									<option value="39">高知県</option>
								</optgroup>
								<optgroup label="九州">
									<option value="40">福岡県</option>
									<option value="41">佐賀県</option>
									<option value="42">長崎県</option>
									<option value="43">熊本県</option>
									<option value="44">大分県</option>
									<option value="45">宮崎県</option>
									<option value="46">鹿児島県</option>
								<option value="47">沖縄県</option>
								</optgroup>
							</select>
                        </span>
                    </li>
                    <li class="st3">
                        <span class="formStep">
                            <select id="objectCity_{{$idNo}}" class="objectCity" name="objectCity">
                                <option selected="selected">市区町村を選択</option>
                            </select>
                        </span>
                    </li>
                    <li class="st4">
                        <span class="formStep">
                            <select id="objectTown_{{$idNo}}" class="objectTown" name="objectTown">
                                <option selected="selected">町名を選択</option>
                            </select>
                        </span>
                    </li>
                </ul>
                <div class="submit">
                    <input type="submit" class="submitButton" value="最短45秒無料査定">
                </div>
                <input type="hidden" name="formId" value="{{$body['formId']}}">
                <img class="pMark" src="/images/pMark.gif" alt="プライバシーマーク"/>
                <ul class="warningPmark">
                    <li><img src="/images/warning.png" width="18" height="15" alt=""/>本サービスは売却検討中の方向けの、不動産会社に査定依頼ができるサービスです。</li>
                    <li><img src="/images/warning.png" width="18" height="15" alt=""/>査定依頼後、不動産会社より連絡があります。</li>
                </ul>
            </form>
        </div>
    </div>
</div>

<script>

    function clearCityList()
    {
        $('.objectCity').each(function()
        {
           $(this).remove();
        });
    }

    function storeCityList(items)
    {
        $.each(items, function(key, val)
        {
            $('.objectCity').append($("<option>").val(key).text(val));
        });
    }

    $('.objectPrefecture').on('change', function(e)
    {
        $.ajax(
            {
                url     : '/api/form/city/' + $(this).val(),
                dataType: 'json',
                type    : 'GET',
                data    : ''
            })
            .then(function(res)
            {
                storeCityList(res);
            });
    });

    function clearTownList()
    {
        $('.objectTown').each(function()
        {
            $(this).remove();
        });
    }

    function storeTownList(items)
    {
        $.each(items, function(key, val)
        {
            $('.objectTown').append($("<option>").val(key).text(val));
        });
    }

    $('.objectCity').on('change', function(e)
    {
        $.ajax(
            {
                url     : '/api/form/town/' + $(this).val(),
                dataType: 'json',
                type    : 'GET',
                data    : ''
            })
            .then(function(res)
            {
                storeTownList(res);
            });
    });
</script>
