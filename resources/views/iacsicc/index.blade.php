<!DOCTYPE html>
<html>
    {{--掲載数、クライアント数などはここで定義してください--}}
    <?php $clientCount = '1,400' ?>

    <head>
        @include('Iacsicc/parts/common/htmlHead')
    </head>
    <body id="body_{{$type}}">
        <?php $idNo = -1; ?>
        @include('Iacsicc/parts/common/bodyHead')
        @include('Iacsicc/parts/common/bodyMainImg')
        <?php $idNo++; ?>
        @include('Iacsicc/parts/common/bodySfForm')

        @if ($type == 'index')
            @include('Iacsicc/parts/index/bodyContent')
        @else
            @include('Iacsicc/parts/area/bodyContent')
        @endif

        <div>
            <p class="formCopy">
                @if ($type != 'index')
                    〇〇の
                @endif
                不動産価格・不動産売買の相場で無料一括査定<br>
                <span class="redTxt">最高価格</span>で売るなら<span class="redTxt">最大6社</span>で比較検討<br>
                <span class="redTxt">1分以内</span>の簡単入力！<br>
                @if ($type != 'index')
                    〇〇の不動産価格に詳しい
                @else
                    1,400社以上の
                @endif
                不動産会社が対応！
            </p>
            <?php $idNo++; ?>
            @include('Iacsicc/parts/common/bodySfForm')
        </div>
        @include('Iacsicc/parts/common/bodyFormButton')

        @if ($type != 'index')
            <div class="inner sp">
                <ul class="breadcrumb clearfix">
                    <li class="name">〇〇</li>
                </ul>
            </div>
        @endif
        @include('Iacsicc/parts/common/bodyFoot')
    </body>
</html>
