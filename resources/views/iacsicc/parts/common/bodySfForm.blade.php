<div class="form_0{{$idNo}}">
    <div class="formArea">
        <div class="inner">
            <form id="form_{{$idNo}}" method="post" action="https://www.sumaistar.{$smarty.const.DOMAIN|regex_replace:'/^([^\.]+\.)+/':''}/drive/form/sell/" class="form">
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
                                <option selected="selected">都道府県を選択</option>
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
                <input type="hidden" name="formId" value="
                        @if (isset($formId))
                            {{$formId}}
                        @else
                            tsfol111souba_fudosan
                        @endif
                        ">
                <img class="pMark" src="/images/pMark.gif" alt="プライバシーマーク"/>
                <ul class="warningPmark">
                    <li><img src="/images/warning.png" width="18" height="15" alt=""/>本サービスは売却検討中の方向けの、不動産会社に査定依頼ができるサービスです。</li>
                    <li><img src="/images/warning.png" width="18" height="15" alt=""/>査定依頼後、不動産会社より連絡があります。</li>
                </ul>
            </form>
        </div>
    </div>
</div>

