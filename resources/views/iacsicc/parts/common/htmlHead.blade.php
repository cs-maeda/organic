<meta charset="utf-8">
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta name="keywords" content="{if isset($meta)}{$meta.keywords}{/if}" />
<meta name="description" content="{if isset($meta)}{$meta.description}{/if}" />
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow" />
<meta name="viewport" content="width=device-width">

<link rel="canonical" href="{$head.canonical}" />
<link rel="shortcut icon" href="/favicon.ico" />
<link href="/css/iacsicc.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/js/organic.js"></script>

<script type="text/javascript">
    /***********************************************************
     * ページ動作定義
     ***********************************************************/
    $.drive.config = {
        // サービス名 ------------------------------------------
        site : 'sell',
        siteCode : 'sf',
    };
    $().ready(
        function()
        {
            // ハイライト表示
            $.drive.ui.setFocusHilite('form_0');
            $.drive.ui.setFocusHilite('form_1');
            $.drive.ui.setFocusHilite('form_2');
            $.drive.ui.setFocusHilite('form_3');
            $.drive.ui.setFocusHilite('form_4');
            //$.drive.ui.setFocusHilite('topForm_0', 'self'); selectにclassを付ける時
            // フォームの動作
            $.drive.el.setObjectAddress('.object');
            // 都道府県リスト内容を埋め込む
            $.drive.ui.setPrefecturePulldown({"targetId":".objectPrefecture"});
            // 物件種別および地域の初期値対応
            $.drive.ui.setUrlValues();
            $.drive.ui.setRequest();
        }
    );
</script>

<title>{{$body['meta']['title']}}</title>
