<header class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{trans('admin/header.menu')}}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @include('admin.header.logout')
                </div>
            </li>
        </ul>
    </div>
</header>
