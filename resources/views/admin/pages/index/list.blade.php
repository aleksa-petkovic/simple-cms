<tr>
    @foreach ($pages as $page)
        @include('admin.pages.index.item', ['page' => $page])
    @endforeach
</tr>
