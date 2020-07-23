<?php

$editUrl = URL::action('App\Content\Http\Controllers\Admin\Article\Controller@edit', ['article' => $article->id]);
$deleteUrl = URL::action('App\Content\Http\Controllers\Admin\Article\Controller@confirmDelete', ['article' => $article->id]);

?>
<tr>
    <td class="align-content-md-stretch">{{$article->title}}</td>
    <td class="border-right">
        <a class="btn btn-outline-primary" type="button" href="{{ $editUrl }}">
            <span>{{ trans('admin/articles.index.links.edit') }}</span>
        </a>
        <a class="btn btn-outline-danger" type="button" href="{{ $deleteUrl }}">
            <span>{{ trans('admin/articles.index.links.delete') }}</span>
        </a>
    </td>
</tr>
