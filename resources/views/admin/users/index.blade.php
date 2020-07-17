@extends('layouts.admin')

<?php

$currentUrl = URL::action('App\Auth\Http\Controllers\Admin\User\Controller@index');
$createUrl = URL::action('App\Auth\Http\Controllers\Admin\User\Controller@create');

?>

@section('content')

    <div class="container-fluid">
    <a href="{{ $currentUrl }}" class="itemList btn btn-md btn-outline-info"><i></i> {{ trans('admin/users.index.links.roles.all') }}</a>
    <a href="{{ $currentUrl }}?roles[]=admin" class="itemList btn btn-md btn-outline-info"><i ></i> {{ trans('admin/users.index.links.roles.admins') }}</a>
    <a href="{{ $currentUrl }}?roles[]=user" class="itemList btn btn-md btn-outline-info"><i ></i> {{ trans('admin/users.index.links.roles.users') }}</a>
    <div class="float-right">
        <a href="{{ $createUrl }}" class="itemList btn btn-md btn-outline-primary">
            <span class="hidden-xs">{{ trans('admin/users.index.links.create') }}</span>
        </a>
    </div>
    </div>
    <table class="table table-striped table-responsive-md btn-table">

        <thead>
        <tr>
            <th>
            {{ trans('admin/users.labels.fullName') }}
            </th>
            <th>
            {{ trans('admin/users.labels.email') }}
            </th>
            <th>
            {{ trans('admin/users.labels.roles') }}
            </th>
        </tr>
        </thead>

        <tbody>
            @include('admin.users.index.list', ['users' => $users])
        </tbody>

    </table>

@stop
