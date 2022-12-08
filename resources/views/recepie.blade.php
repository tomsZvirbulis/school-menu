@extends('layouts.main')

@section('content')
    <div>
        @if (isset($data))
            @foreach ($data as $recepie)
                <h1>{{$recepie->name}}</h1>
            @endforeach
        @endif
    </div>
@endsection