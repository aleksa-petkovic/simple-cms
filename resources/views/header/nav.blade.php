<?php

use Illuminate\Support\Arr;

$adminPanelUrl = URL::action('App\Http\Controllers\Admin\LoginController@login')

?>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #1d2124">
    <?php
    $activeKey = $navigation('front.main')->getActive();
    ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
            @foreach ($navigation('front.main')->getItems() as $key => $item)

                <?php
                $isActive = ($key === $activeKey);
                $articles = Arr::get($item, 'articles', null);
                $hasDropDown = is_array($articles) ? !empty($articles) : $articles !== null && !$articles->isEmpty();
                $is_selectable = Arr::get($item, 'selectable_in_navigation', 1);
                ?>

            <li class="nav-item active{{ $hasDropDown ? 'nav-item dropdown' : '' }}" >
                <a class="nav-link {{ $hasDropDown ? 'nav-link dropdown' : '' }} {{ $isActive ? 'nav-link active' : '' }}" data-toggle="dropdown"
                   style="-webkit-text-fill-color: beige" href="{{ $is_selectable ? $item['href'] : '#' }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $item['label'] }}
                    </a>
                @if($hasDropDown)
                    <ul class="dropdown-menu">
                        @foreach($item['articles'] as $article)
                            <li>
                                <a class="dropdown-item" href="{{ isset($article['url']) ? $article['url'] : URL::action('App\Content\Http\Controllers\Front\Page\Controller@resolveRoute', ['any' => $article->full_slug]) }}">
                                    {{is_array($article) ? $article['title'] : $article->title}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
            @endforeach
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" style="-webkit-text-fill-color: beige" href="{{ $adminPanelUrl }}">
                    {{trans('navigation.admin')}}
                </a>
            </li>
        </ul>
    </div>
</nav>
