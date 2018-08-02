<div class="breadcrumb">
    <ul class="listBreadcrumb clearfix">
        @foreach($body['breadcrumb'] as $breadcrumb)
            <li>
                @if ($breadcrumb['link'] != '')
                    <a href="{{$breadcrumb['link']}}">{{$breadcrumb['caption']}}</a>
                @else
                    {{$breadcrumb['caption']}}
                @endif
            </li>
        @endforeach
    </ul>
</div>
