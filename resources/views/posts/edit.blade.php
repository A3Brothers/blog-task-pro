<x-app-layout>
    <x-slot:title>
        {{ __('Edit Post') }}
    </x-slot>

    <div class="max-w-2xl mx-auto my-8 p-4 bg-white shadow rounded-lg">

        <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Edit a Blog Post') }}</h1>

        <form action="{{ route('post.update', ['post' => $post->slug]) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $post->title)"
                    required />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <div class="mb-4">
                <x-input-label for="editor" :value="__('Content')" />
                <x-textarea class="h-1/4" name="content" id="editor" cols="30"
                    rows="10">{{ old('content', $post->content) }}</x-textarea>
                <x-input-error class="mt-2" :messages="$errors->get('content')" />
            </div>

            <div class="text-center">
                <x-primary-button>{{ __('Submit') }}</x-primary-button>
            </div>
        </form>

    </div>

    @push('js')
        <script src="{{ asset('assets/js/editor.js') }}"></script>
    @endpush
</x-app-layout>
