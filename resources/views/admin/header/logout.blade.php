<?php

$url = URL::action('App\Http\Controllers\Admin\LoginController@logout');

?>

{!! Form::open(['url' => $url, 'class' => 'header-logoutForm']) !!}

{{-- Submit button --}}

<div class="form-group header-logoutButton--container js-rippleButton rippleButton rippleButton--primary">
    {!!
        Form::button(
            '<span class="btn"> '.trans('admin/header.logout.default').'</span>',
            [
                'class' => 'header-logoutButton',
                'type' => 'submit',
                'data-loading-text' => '<i class="fa fa-clock-o fa-spin"></i><span class="header-logoutButton-text"> '.trans('admin/header.logout.loading').'</span>',
            ]
        )
    !!}
</div>

{!! Form::close() !!}
