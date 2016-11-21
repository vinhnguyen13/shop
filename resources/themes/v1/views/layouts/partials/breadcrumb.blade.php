@if(!empty($breadcrumbs))
    <ul class="breakcum">
        @php
        $i = 1;
        @endphp
        @foreach($breadcrumbs as $url => $text)
            <li><a href="{{$url}}">{{$text}}</a></li>
            @if($i < count($breadcrumbs))
                <li><span>/</span></li>
            @endif
            @php
            $i++;
            @endphp
        @endforeach
    </ul>
@endif