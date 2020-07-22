@extends('layouts.front')

@section('content')

<div class="o-container o-container--xs">
    <div class="container">
        <h1>{!! $page->title !!}</h1>
        <div class="o-typeset">
            {!! $page->content !!}
        </div>
        @if ( ! $page->articles->isEmpty())
            <div class="row">
                @foreach($articles as $article)
                    <?php $url = URL::action('App\Content\Http\Controllers\Front\Page\Controller@resolveRoute', ['any' => $article->full_slug]); ?>
                    <div class="col-sm-8">
                        @if($article->getImage('main'))
                        <img src="{{ URL::to($article->getImage('main')) }}" class="card-img-top" height="200">
                        @endif
                        <h2>{{ $article->title }}</h2>
                        <h5>{!! $article->lead !!}</h5>
                        <a href="{{ $url }}" style="-webkit-text-fill-color: gray">{{ trans('buttons.readMore') }}</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    </div>
</div>

@stop
