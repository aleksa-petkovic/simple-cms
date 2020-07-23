<?php

$url = URL::action('App\Http\Controllers\Admin\LoginController@logout');

?>

{!! Form::open(['url' => $url, 'class' => 'header-logoutForm']) !!}

{{-- Submit button --}}


    {!!
        Form::button(
            '<span class="dropdown-item"> '.trans('admin/header.logout.default').'</span>',
            [
                'class' => 'dropdown-item',
                'type' => 'submit',
            ]
        )
    !!}


{!! Form::close() !!}
