@extends('layouts.admin')

<?php

$createUrl = URL::action('App\Content\Http\Controllers\Admin\Article\Controller@create', ['page' => $page->id]);

?>

@section('content')

    <div class="container-fluid">
        <div class="float-right">
            <a href="{{ $createUrl }}" class="itemList btn btn-md btn-outline-primary">
                <span class="hidden-xs">{{ trans('admin/articles.index.links.create') }}</span>
            </a>
        </div>
    </div>
    <table class="table table-striped table-responsive-md btn-table">

        <thead>
        <tr>
            <th>
                {{ trans('admin/articles.labels.title') }}
            </th>
        </tr>
        </thead>

        <tbody>
        @include('admin.articles.index.list', ['articles' => $page->articles])
        </tbody>

    </table>

@stop
