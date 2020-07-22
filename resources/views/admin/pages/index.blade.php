@extends('layouts.admin')

<?php

$currentUrl = URL::action('App\Content\Http\Controllers\Admin\Page\Controller@index');
$createUrl = URL::action('App\Content\Http\Controllers\Admin\Page\Controller@create');

?>

@section('content')

    <div class="container-fluid">
        <div class="float-right">
            <a href="{{ $createUrl }}" class="itemList btn btn-md btn-outline-primary">
                <span class="hidden-xs">{{ trans('admin/pages.index.links.create') }}</span>
            </a>
        </div>
    </div>
    <table class="table table-striped table-responsive-md btn-table">

        <thead>
        <tr>
            <th>
                {{ trans('admin/pages.labels.title') }}
            </th>
        </tr>
        </thead>

        <tbody>
        @include('admin.pages.index.list', ['pages' => $pages])
        </tbody>

    </table>

@stop
