@extends('layouts.front')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                @if($article->getImage('main'))
                <img src="{{ URL::to($article->getImage('main')) }}" class="card-img-top" height="200">
                @endif
                <h2>{{ $article->title }}</h2>
                <h5>{!! $article->lead !!}</h5>
                <p>{!! $article->content !!}.</p>
            </div>
        </div>
    </div>

@stop
