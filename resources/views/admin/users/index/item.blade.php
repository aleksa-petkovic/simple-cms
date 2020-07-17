<?php

$editUrl = URL::action('App\Auth\Http\Controllers\Admin\User\Controller@edit', ['user' => $user->id]);
$deleteUrl = URL::action('App\Auth\Http\Controllers\Admin\User\Controller@confirmDelete', ['user' => $user->id]);

$roles = $user->roles->implode('name', ', ');

?>
<tr>
<td class="align-content-md-stretch">{{$user->full_name}}</td>
<td>{{ $user->email }}</td>
<td>{{ $roles }}</td>
<td class="border-right">
    <a class="btn btn-outline-primary" type="button" href="{{ $editUrl }}">
        <span>{{ trans('admin/users.index.links.edit') }}</span>
    </a>
    <a class="btn btn-outline-danger" type="button" href="{{ $deleteUrl }}">
        <span>{{ trans('admin/users.index.links.delete') }}</span>
    </a>
</td>
</tr>
