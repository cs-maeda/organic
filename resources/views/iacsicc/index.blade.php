<!DOCTYPE html>
<html>
    {{--掲載数、クライアント数などはここで定義してください--}}
    <?php $clientCount = '1,400' ?>
    {{--formのボタンのvalue--}}
    <?php $formButtonValue = '最短45秒無料査定!' ?>

    <head>
        @include('Iacsicc/parts/common/htmlHead')
    </head>
    <body id="body_{{$body['where']}}">
        <?php $idNo = -1; ?>
        @include('Iacsicc/parts/common/bodyHead')
        @include('Iacsicc/parts/common/bodyMainImg')
        <div class="formCopy">
            <p class="catch">{!! $body['copy'][3] !!}</p>
        </div>
        <?php $idNo++; ?>
        @include('common.bodySfForm')

        @if ($body['where'] == 'index')
            @include('Iacsicc/parts/index/bodyContent')
        @else
            @include('Iacsicc/parts/area/bodyContent')
        @endif

        @include('Iacsicc/parts/common/bodyPrefectureLink')

        <div>
            <div class="formCopy">
                <p class="catch">
                @if ($body['where'] != 'index')
                    〇〇の
                @endif
                不動産価格・不動産売買の相場で無料一括査定<br>
                <span class="red">最高価格</span>で売るなら<span class="red">最大6社</span>で比較検討<br>
                <span class="red">1分以内</span>の簡単入力！<br>
                @if ($body['where'] != 'index')
                    〇〇の不動産価格に詳しい
                @else
                    1,400社以上の
                @endif
                不動産会社が対応！
                </p>
            </div>
            <?php $idNo++; ?>
            @include('common.bodySfForm')
        </div>
        @if ($body['where'] != 'index')
            <div class="inner sp">
                <ul class="breadcrumb clearfix">
                    <li class="name">〇〇</li>
                </ul>
            </div>
        @endif
        @include('common/bodyFormButton')
        @include('Iacsicc/parts/common/bodyFoot')
    </body>
</html>
