@extends('layouts.admin')

<?php

$url = URL::action('App\Content\Http\Controllers\Admin\Article\Controller@delete', ['article' => $article->id]);

?>

@section('content')

<div class="alert alert-warning">{{ trans('admin/articles.confirmDelete.message') }}</div>

{!! Form::open(['url' => $url, 'method' => 'delete']) !!}

    <div class="form-group">
        {{-- Confirm button --}}

        {!!
            Form::button(
                '<i class="fa fa-trash-o"></i> '.trans('admin/articles.confirmDelete.confirm.default'),
                [
                    'class' => 'btn btn-lg btn-danger js-rippleButton rippleButton rippleButton--primary',
                    'type' => 'submit',
                    'name' => 'action',
                    'value' => 'confirm',
                    'data-loading-text' => '<i class="fa fa-clock-o fa-spin"></i> '.trans('admin/articles.confirmDelete.confirm.loading'),
                ]
            )
        !!}

        {{-- Cancel button --}}

        {!!
            Form::button(
                '<i class="fa fa-times"></i> '.trans('admin/articles.confirmDelete.cancel.default'),
                [
                    'class' => 'btn btn-lg btn-default js-rippleButton rippleButton rippleButton--primary',
                    'type' => 'submit',
                    'name' => 'action',
                    'value' => 'cancel',
                    'data-loading-text' => '<i class="fa fa-clock-o fa-spin"></i> '.trans('admin/articles.confirmDelete.cancel.loading'),
                ]
            )
        !!}
    </div>

{!! Form::close() !!}

@stop
