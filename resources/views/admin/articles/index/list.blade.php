<tr>
    @foreach ($articles as $article)
        @include('admin.articles.index.item', ['article' => $article])
    @endforeach
</tr>
