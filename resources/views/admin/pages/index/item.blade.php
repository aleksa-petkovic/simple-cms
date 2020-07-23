<?php

$editUrl = URL::action('App\Content\Http\Controllers\Admin\Page\Controller@edit', ['page' => $page->id]);
$deleteUrl = URL::action('App\Content\Http\Controllers\Admin\Page\Controller@confirmDelete', ['page' => $page->id]);
$articlesUrl = URL::action('App\Content\Http\Controllers\Admin\Article\Controller@index', ['page' => $page->id]);

?>
<tr>
    <td class="align-content-md-stretch">{{$page->title}}</td>
    <td class="border-right">
        <a class="btn btn-outline-primary" type="button" href="{{ $articlesUrl }}">
            <span>{{ trans('admin/pages.index.links.articles') }}</span>
        </a>
        <a class="btn btn-outline-primary" type="button" href="{{ $editUrl }}">
            <span>{{ trans('admin/pages.index.links.edit') }}</span>
        </a>
        <a class="btn btn-outline-danger" type="button" href="{{ $deleteUrl }}">
            <span>{{ trans('admin/pages.index.links.delete') }}</span>
        </a>
    </td>
</tr>
