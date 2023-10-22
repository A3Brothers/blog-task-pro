<x-app-layout>
    <x-slot:title>
        {{ __('Post List') }}
    </x-slot>

    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Latest Posts') }}
        </h2>
    </x-slot>

    <div class="w-9/12 lg:w-1/3 md:w-1/2 mx-auto text-center">
        <div id="postsBlock">
            <ul>
                @forelse ($posts as $post)
                    <li
                        class="border shadow my-4 p-4 rounded-md bg-white hover:scale-105 hover:bg-slate-50 transition duration-300">
                        <h3 class="font-bold mt-2 mb-4 text-blue-400 hover:text-blue-500 border-b-2"><a
                                href="{{ route('post.show', ['post' => $post->slug]) }}">{{ $post->title }}</a>
                        </h3>
                        <p>{{ words($post->content, stripHtml: true) }} </p>
                    </li>
                @empty
                    <div class="text-slate-500 font-bold uppercase m-4">{{ __('No Post') }}</div>
                @endforelse
            </ul>
            {{-- {{ $posts->links() }} --}}
        </div>
        <button id="scrollToTop"
            class="fixed bottom-4 right-4 bg-blue-500 text-white rounded-full p-2 hover:bg-blue-600 hidden">
            {{ __('Scroll to Top') }}
        </button>
        <div id="infinite-scroll-trigger-reached" class="text-slate-500 font-bold uppercase m-4"></div>
    </div>

    @push('js')
        <script>
            const target = document.querySelector('#infinite-scroll-trigger-reached');
            const postsBlock = document.querySelector('#postsBlock');
            const scrollTop = document.querySelector('#scrollToTop');

            let lastPage = false;

            function handleIntersection(entries) {
                const entry = entries[0];
                if (entry.isIntersecting) {
                    if (!lastPage) {
                        loadMorePosts();
                        console.log('intersection loaded')
                    }

                }
            }

            let options = {
                root: null,
                rootMargin: "50%",
                threshold: 0.0,
            };

            const observer = new IntersectionObserver(handleIntersection, options);
            observer.observe(target);

            var url = "{{ $posts->nextPageUrl() }}";
            const loadMorePosts = async () => {
                try {
                    if (url) {
                        let response = await window.axios.get(url, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        if (!response.data.lastPage) {
                            history.pushState({}, "", url);
                            url = response.data.nextPageUrl
                            postsBlock.insertAdjacentHTML('beforeend', response.data.html);
                        }
                    }
                } catch (err) {
                    console.log(err);
                }

            }

            scrollTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                    scrollTop.classList.remove('hidden');
                } else {
                    scrollTop.classList.add('hidden');
                }
            });
        </script>
    @endpush

</x-app-layout>
