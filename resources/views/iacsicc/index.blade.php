<!DOCTYPE html>
<html>
    {{--掲載数、クライアント数などはここで定義してください--}}
    <?php $clientCount = '1,400' ?>
    {{--formのボタンのvalue--}}
    <?php $formButtonValue = '最短45秒無料査定!' ?>

    <head>
        @include('common.htmlHead')
    </head>
    <body id="body_{{$body['where']}}">
        <?php $idNo = -1; ?>
        @include('common.bodyHead')
        @include('iacsicc/parts/common/bodyMainImg')
        <div class="formCopy">
            <p class="catch">{!! $body['copy'][3] !!}</p>
        </div>
        <?php $idNo++; ?>
        @include('common.bodySfForm')
        @if ($body['where'] != 'index')
            @include('common.bodyBreadcrumb')
        @endif

        @if ($body['where'] == 'index')
            @include('iacsicc/parts/index/bodyContent')
        @else
            @include('iacsicc/parts/area/bodyContent')
        @endif

        @include('common.bodyPrefectureLink')

        <div>
            <div class="formCopy">
                <p class="catch">
                {{$body['areaCaptionOf']}}不動産価格・不動産売買の相場で無料一括査定<br>
                <span class="red">最高価格</span>で売るなら<span class="red">最大6社</span>で比較検討<br>
                <span class="red">1分以内</span>の簡単入力！<br>
                @if ($body['where'] != 'index')
                    {{$body['areaCaptionOf']}}不動産価格に詳しい
                @else
                    1,400社以上の
                @endif
                不動産会社が対応！
                </p>
            </div>
            <?php $idNo++; ?>
            @include('common.bodySfForm')
        </div>
        @include('common/bodyFormButton')
        @include('iacsicc/parts/common/bodyFoot')
    </body>
</html>
