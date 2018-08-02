{{--@section('content')--}}
<!DOCTYPE html>
<html>
    <head>
        <link href="/css/organic.css" rel="stylesheet" type="text/css">
        <link href="/css/{{$body['css']}}" rel="stylesheet" type="text/css">
        <title>{{$body['headLine']}}</title>
    </head>
    <body>
        @include('common.bodyHead')
        @include('errors.bodyCommon')
        <footer class="pageFoot">
            <div class="inner">
                <ul class="footerMenu">
                    <li><a href="/">トップページ</a></li>
                </ul>
            </div>
        </footer>
    </body>
</html>
{{--@endsection--}}

