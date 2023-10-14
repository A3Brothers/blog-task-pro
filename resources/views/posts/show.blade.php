<x-app-layout>
    <x-slot:title>
        {{ $post->title }}
    </x-slot>

    <article>
        <div class="max-w-2xl mx-auto my-16 p-4 bg-white shadow rounded-lg md:p-8 lg:max-w-4xl">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4 md:text-3xl lg:text-4xl">
                {{ $post->title }}
            </h1>

            <div class="flex flex-wrap items-center text-gray-600 text-sm">
                <div class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9l-8 8 2-10 6-2 6 2 2 10-8-8z" />
                    </svg>
                </div>
                <span class="mr-2">{{ $post->user->name }}</span>
                <div class="mr-2">•</div>
                <span class="mb-2 md:mb-0">{{ $post->published_at->diffForHumans() }}</span>
                @can('update', $post)
                    <div class="ml-auto mt-2 md:mt-0">
                        <a href="{{ route('post.edit', ['post' => $post->slug]) }}">
                            <button class="text-blue-500 hover:underline mr-2">{{ __('Edit') }}</button>
                        </a>
                    </div>

                    <div>
                        <button x-data="" type="button" class="text-red-500 hover:underline"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete') }}</button>
                    </div>

                    <x-modal name="confirm-user-deletion" focusable>
                        <form method="post" action="{{ route('post.destroy', ['post' => $post->slug]) }}" class="p-6">
                            @csrf
                            @method('delete')

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Are you sure you want to delete this post?') }}
                            </h2>

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ml-3">
                                    {{ __('Delete Post') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                @endcan
            </div>

            <div class="text-gray-700 mt-4 md:text-lg lg:text-xl">
                <p>{!! $post->content !!}</p>
            </div>
        </div>
    </article>
</x-app-layout>
