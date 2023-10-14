@foreach ($posts as $post)
    <div class="border-2 my-4 p-4 rounded-md bg-white hover:scale-105 hover:bg-slate-50 transition duration-500">
        <h3 class="font-bold mt-2 mb-4 text-blue-400 hover:text-blue-500"><a
                href="{{ route('post.show', ['post' => $post->slug]) }}">{{ $post->title }}</a>
        </h3>
        <p>{{ words($post->content, stripHtml: true) }}</p>
    </div>
@endforeach
