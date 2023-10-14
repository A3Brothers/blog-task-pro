@can('update', $post)
    <div class="ml-auto mt-2 md:mt-0">
        <a href="{{ route('post.edit', ['post' => $post->slug]) }}">
            <button class="text-blue-500 hover:underline mr-2">{{ __('Edit') }}</button>
        </a>
    </div>

    <div>
        <button x-data="" type="button" class="text-red-500 hover:underline"
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $post->id }}')">{{ __('Delete') }}</button>
    </div>

    <x-modal name="confirm-user-deletion-{{ $post->id }}" focusable>
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
