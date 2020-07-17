<?php

$activeKey = $navigation('admin.main')->getActive();

?>

<div class="bg-light border-right" >
    <div class="list-group list-group-flush">
        @foreach ($navigation('admin.main')->getItems() as $key => $item)
            <?php $isActive = ($key === $activeKey); ?>
        <a href="{{ $item['href'] }}" class="list-group-item list-group-item-action bg-light" {{ $isActive ? 'is-active' : '' }}> {{ $item['label'] }}</a>
        @endforeach
    </div>
</div>



