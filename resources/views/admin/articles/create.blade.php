@extends('layouts.admin')

<?php

$url = URL::action('App\Content\Http\Controllers\Admin\Article\Controller@store', ['page' => $page->id]);

?>

@section('content')

    @if (!$errors->isEmpty())
        <div class="alert alert-danger">{{ trans('common.genericFormError') }}</div>
    @endif

    {!! Form::open(['url' => $url, 'method' => 'post', 'files' => true]) !!}

    {{-- Basic configuration --}}

    <div class="card-header ">
        <div class="align-content-md-stretch bg-light border-bottom">
            <p class="font-weight-bold">{{ trans('admin/articles.panelTitles.basicConfiguration') }}</p>
        </div>
    </div>

    <div class="card-body">


        {{-- Title --}}

        <div class="form-group">
            {!! Form::label('title', trans('admin/articles.labels.title')) !!}
            <div class="input-group">
                {!! Form::text('title', null, ['size' => '60']) !!}
            </div>

            @if ($errors->has('title'))
                <p class="alert alert-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>


        {{-- Slug --}}

        <div class="form-group">
            {!! Form::label('slug', trans('admin/articles.labels.slug')) !!}
            <div class="input-group">
                {!! Form::text('slug', null, ['size' => '60']) !!}
            </div>

            @if ($errors->has('slug'))
                <p class="alert alert-danger">{{ $errors->first('slug') }}</p>
            @endif
        </div>


        {{-- Template --}}

        <div class="form-group">
            {!! Form::label('template', trans('admin/articles.labels.template')) !!}
            <div class="dropdown">
                {!! Form::select('template', $templateOptions, null) !!}
            </div>

            @if ($errors->has('template'))
                <p class="alert alert-danger">{{ $errors->first('template') }}</p>
            @endif
        </div>


        {{-- Lead --}}

        <div class="form-group">
            {!! Form::label('lead', trans('admin/articles.labels.lead')) !!}
            <div class="input-group">
                {!! Form::text('lead', null, ['size' => '60']) !!}
            </div>

            @if ($errors->has('lead'))
                <p class="alert alert-danger">{{ $errors->first('lead') }}</p>
            @endif
        </div>


        {{-- Content --}}

        <div class="form-group">
            {!! Form::label('content', trans('admin/articles.labels.content')) !!}
            <div class="input-group">
                {!! Form::textarea('content', null) !!}
            </div>

            @if ($errors->has('content'))
                <p class="alert alert-danger">{{ $errors->first('content') }}</p>
            @endif
        </div>


        {{-- Main image --}}

        <div class="form-group">
            {!! Form::label('image_main', trans('admin/articles.labels.imageMain')) !!}
            <div class="">
                {!! Form::file('image_main') !!}
                <span class=""></span>
            </div>

            <p class="">{!! trans('admin/articles.help.imageMain') !!}</p>

            @if ($errors->has('image_main'))
                <p class="">{{ $errors->first('image_main') }}</p>
            @endif
        </div>


        {{-- Submit button --}}

        <div class="form-group">
            {!!
                Form::button(
                    '<i class="fa fa-save"></i> '.trans('admin/articles.labels.save.default'),
                    [
                        'class' => 'btn btn-lg btn-primary',
                        'type' => 'submit',
                    ]
                )
            !!}
        </div>

    </div>

    {!! Form::close() !!}

@stop
