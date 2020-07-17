<tr>
    @foreach ($users as $user)
        @include('admin.users.index.item', ['user' => $user])
    @endforeach
</tr>
