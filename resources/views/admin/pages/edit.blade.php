@extends('layouts.admin')

<?php

$url = URL::action('App\Content\Http\Controllers\Admin\Page\Controller@update', ['page' => $page->id]);

?>

@section('content')

    @if (!$errors->isEmpty())
        <div class="alert alert-danger">{{ trans('common.genericFormError') }}</div>
    @endif

    {!! Form::open(['url' => $url, 'method' => 'put', 'files' => true]) !!}

    {{-- Basic configuration --}}

    <div class="card-header ">
        <div class="align-content-md-stretch bg-light border-bottom">
            <p class="font-weight-bold">{{ trans('admin/pages.panelTitles.basicConfiguration') }}</p>
        </div>
    </div>

    <div class="card-body">


        {{-- Title --}}

        <div class="form-group">
            {!! Form::label('title', trans('admin/pages.labels.title')) !!}
            <div class="input-group">
                {!! Form::text('title', $page->title, ['size' => '60']) !!}
            </div>

            @if ($errors->has('title'))
                <p class="alert alert-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>


        {{-- Slug --}}

        <div class="form-group">
            {!! Form::label('slug', trans('admin/pages.labels.slug')) !!}
            <div class="input-group">
                {!! Form::text('slug', $page->slug, ['size' => '60']) !!}
            </div>

            @if ($errors->has('slug'))
                <p class="alert alert-danger">{{ $errors->first('slug') }}</p>
            @endif
        </div>


        {{-- Template --}}

        <div class="form-group">
            {!! Form::label('template', trans('admin/pages.labels.template')) !!}
            <div class="dropdown">
                {!! Form::select('template', $templateOptions, $page->template) !!}
            </div>

            @if ($errors->has('template'))
                <p class="alert alert-danger">{{ $errors->first('template') }}</p>
            @endif
        </div>


        {{-- Lead --}}

        <div class="form-group">
            {!! Form::label('lead', trans('admin/pages.labels.lead')) !!}
            <div class="input-group">
                {!! Form::text('lead', $page->lead, ['size' => '60']) !!}
            </div>

            @if ($errors->has('lead'))
                <p class="alert alert-danger">{{ $errors->first('lead') }}</p>
            @endif
        </div>


        {{-- Content --}}

        <div class="form-group">
            {!! Form::label('content', trans('admin/pages.labels.content')) !!}
            <div class="input-group">
                {!! Form::textarea('content', $page->content) !!}
            </div>

            @if ($errors->has('content'))
                <p class="alert alert-danger">{{ $errors->first('content') }}</p>
            @endif
        </div>


        {{-- Main image --}}

        <div class="form-group">
            {!! Form::label('image_main', trans('admin/pages.labels.imageMain')) !!}
            @if ($page->hasImage('main'))
                <div class="input-group">
                    <img src="{{ $page->getImage('main') }}">

                    <div >
                        <label class="">
                            {!! Form::checkbox('image_main_delete', 1, false) !!}
                            <span class="">{{ trans('admin/pages.labels.imageMainDelete') }}</span>
                        </label>
                    </div>
                </div>
            @endif
            <div class="">
                {!! Form::file('image_main') !!}
                <span class=""></span>
            </div>

            <p class="">{!! trans('admin/pages.help.imageMain') !!}</p>

            @if ($errors->has('image_main'))
                <p class="">{{ $errors->first('image_main') }}</p>
            @endif
        </div>


        {{-- Show in navigation --}}

        <div class="form-group">
            <label class="form-check">
                {!! Form::checkbox('show_in_navigation', 1, $page->show_in_navigation) !!}
                <span class="text">{{ trans('admin/pages.labels.showInNavigation') }}</span>
            </label>
        </div>

        {{-- Selectable in navigation --}}

        <div class="form-group">
            <label class="form-check">
                {!! Form::checkbox('selectable_in_navigation', 1, $page->selectable_in_navigation) !!}
                <span class="text">{{ trans('admin/pages.labels.selectableInNavigation') }}</span>
            </label>
        </div>

        {{-- Show articles in navigation --}}

        <div class="form-group">
            <label class="form-check">
                {!! Form::checkbox('show_articles_in_navigation', 1, $page->show_articles_in_navigation) !!}
                <span class="text">{{ trans('admin/pages.labels.showArticlesInNavigation') }}</span>
            </label>
        </div>


        {{-- Submit button --}}

        <div class="form-group">
            {!!
                Form::button(
                    '<i class="fa fa-save"></i> '.trans('admin/pages.labels.save.default'),
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
