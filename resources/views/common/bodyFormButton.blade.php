
<div class="formButton sp">
    <a href="https://www.sumaistar.<?php
        if (preg_replace('/^.+\.([^\.]+)$/', '$1', $_SERVER['HTTP_HOST']) == 'dev') {
            print 'dev';
        } else {
            print 'com';
        } ?>/drive/form/sell/?formId={{$body['formId']}}" class="button">{{$body['form']['buttonValue']}}　START</a>
</div>

