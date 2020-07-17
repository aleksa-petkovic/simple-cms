@extends('layouts.admin')

<?php

$url = URL::action('App\Auth\Http\Controllers\Admin\User\Controller@update', ['user' => $user->id]);

?>

@section('content')

@if (!$errors->isEmpty())
    <div class="alert alert-danger">{{ trans('common.genericFormError') }}</div>
@endif

{!! Form::open(['url' => $url, 'method' => 'put', 'files' => true]) !!}

{{-- Basic configuration --}}

<div class="card-header ">
    <div class="align-content-md-stretch bg-light border-bottom">
        <p class="font-weight-bold">{{ trans('admin/users.panelTitles.basicConfiguration') }}</p>
    </div>
</div>

<div class="card-body">


    {{-- Role --}}

    <div class="form-group">
        {!! Form::label('role', trans('admin/users.labels.role')) !!}
        <div class="dropdown">
            {!! Form::select('role', $roleOptions, $user->role->slug) !!}
        </div>

        @if ($errors->has('role'))
            <p class="alert alert-danger">{{ $errors->first('role') }}</p>
        @endif
    </div>


    {{-- Email --}}

    <div class="form-group">
        {!! Form::label('email', trans('admin/users.labels.email')) !!}
        <div class="input-group">
            {!! Form::email('email', $user->email, ['size' => '60']) !!}
        </div>

        @if ($errors->has('email'))
            <p class="alert alert-danger">{{ $errors->first('email') }}</p>
        @endif
    </div>


    {{-- Password --}}

    <div class="form-group">
        {!! Form::label('password', trans('admin/users.labels.password')) !!}
        <div class="input-group">
            {!! Form::password('password') !!}
        </div>

        @if ($errors->has('password'))
            <p class="alert alert-danger">{{ $errors->first('password') }}</p>
        @endif
    </div>


    {{-- First name --}}

    <div class="form-group">
        {!! Form::label('first_name', trans('admin/users.labels.firstName'), ['class' => 'c-inputLabel']) !!}
        <div class="input-group">
            {!! Form::text('first_name', $user->first_name, ['size' => '15', 'required']) !!}
        </div>

        @if ($errors->has('first_name'))
            <p class="alert alert-danger">{{ $errors->first('first_name') }}</p>
        @endif
    </div>


    {{-- Last name --}}

    <div class="form-group">
        {!! Form::label('last_name', trans('admin/users.labels.lastName')) !!}
        <div class="input-group">
            {!! Form::text('last_name', $user->last_name, ['class' => 'c-inputField', 'size' => '20', 'required']) !!}
        </div>

        @if ($errors->has('last_name'))
            <p class="alert alert-danger">{{ $errors->first('last_name') }}</p>
        @endif
    </div>



    {{-- Send welcome email --}}

    <div class="form-group">
        <label class="form-check">
            {!! Form::checkbox('send_welcome_email', 1, false) !!}
            <span class="text">{{ trans('admin/users.labels.sendWelcomeEmail') }}</span>
        </label>
    </div>


    {{-- Submit button --}}

    <div class="form-group">
        {!!
            Form::button(
                '<i class="fa fa-save"></i> '.trans('admin/users.labels.save.default'),
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
