<header class="navbar navbar-expand-lg border-bottom" style="background-color: #1d2124">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown" href="#" role="button" data-toggle="dropdown" style="-webkit-text-fill-color: beige" aria-haspopup="true" aria-expanded="false">
                  {{trans('admin/header.menu')}}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @include('admin.header.logout')
                </div>
            </li>
        </ul>
</header>
