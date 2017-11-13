<html>
<head>
</head>
<body>
    @if(isset($p))
        {!! $p->plantilla !!}
        @if(!is_null($p->img1))
        <img src="{{ $message->embed($storage_path('app') . "/plantillas_correos/" . $p->img1) }}">
        @endif
    @else
        {!! $plantilla !!}
        @if(!is_null($img1))
        <img src="{{ $message->embed($storage_path('app') . "/plantillas_correos/" . $img1) }}">
        @endif
    @endif
    
</body>
</html>