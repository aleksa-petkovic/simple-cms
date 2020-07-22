@extends('layouts.admin')

<?php

$url = URL::action('App\Content\Http\Controllers\Admin\Page\Controller@delete', ['page' => $page->id]);

?>

@section('content')

<div class="alert alert-warning">{{ trans('admin/pages.confirmDelete.message') }}</div>

{!! Form::open(['url' => $url, 'method' => 'delete']) !!}

    <div class="form-group">
        {{-- Confirm button --}}

        {!!
            Form::button(
                '<i class="fa fa-trash-o"></i> '.trans('admin/pages.confirmDelete.confirm.default'),
                [
                    'class' => 'btn btn-lg btn-danger js-rippleButton rippleButton rippleButton--primary',
                    'type' => 'submit',
                    'name' => 'action',
                    'value' => 'confirm',
                    'data-loading-text' => '<i class="fa fa-clock-o fa-spin"></i> '.trans('admin/pages.confirmDelete.confirm.loading'),
                ]
            )
        !!}

        {{-- Cancel button --}}

        {!!
            Form::button(
                '<i class="fa fa-times"></i> '.trans('admin/pages.confirmDelete.cancel.default'),
                [
                    'class' => 'btn btn-lg btn-default js-rippleButton rippleButton rippleButton--primary',
                    'type' => 'submit',
                    'name' => 'action',
                    'value' => 'cancel',
                    'data-loading-text' => '<i class="fa fa-clock-o fa-spin"></i> '.trans('admin/pages.confirmDelete.cancel.loading'),
                ]
            )
        !!}
    </div>

{!! Form::close() !!}

@stop
