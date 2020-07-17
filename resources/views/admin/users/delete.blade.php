@extends('layouts.admin')

<?php

$url = URL::action('App\Auth\Http\Controllers\Admin\User\Controller@delete', ['user' => $user->id]);

?>

@section('content')

<div class="alert alert-warning">{{ trans('admin/users.confirmDelete.message') }}</div>

{!! Form::open(['url' => $url, 'method' => 'delete']) !!}

    <div class="form-group">
        {{-- Confirm button --}}

        {!!
            Form::button(
                '<i class="fa fa-trash-o"></i> '.trans('admin/users.confirmDelete.confirm.default'),
                [
                    'class' => 'btn btn-lg btn-danger js-rippleButton rippleButton rippleButton--primary',
                    'type' => 'submit',
                    'name' => 'action',
                    'value' => 'confirm',
                    'data-loading-text' => '<i class="fa fa-clock-o fa-spin"></i> '.trans('admin/users.confirmDelete.confirm.loading'),
                ]
            )
        !!}

        {{-- Cancel button --}}

        {!!
            Form::button(
                '<i class="fa fa-times"></i> '.trans('admin/users.confirmDelete.cancel.default'),
                [
                    'class' => 'btn btn-lg btn-default js-rippleButton rippleButton rippleButton--primary',
                    'type' => 'submit',
                    'name' => 'action',
                    'value' => 'cancel',
                    'data-loading-text' => '<i class="fa fa-clock-o fa-spin"></i> '.trans('admin/users.confirmDelete.cancel.loading'),
                ]
            )
        !!}
    </div>

{!! Form::close() !!}

@stop
