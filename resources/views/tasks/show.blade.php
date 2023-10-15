<x-app-layout>

    <x-slot:title>
        {{ __('Task Details') }}
    </x-slot>

    <div class="bg-white shadow-md rounded-lg max-w-lg mx-auto p-4">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Task Details') }}</h1>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
            <div class="text-lg text-gray-800">{{ $task->title }}</div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
            <div class="text-gray-800">{!! $task->description !!}</div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
            <div class="text-lg {{ $task->status === 'completed' ? 'text-green-600' : 'text-red-600' }}">
                {{ $task->status }}</div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Due Date') }}</label>
            <div class="text-lg text-gray-800">{{ Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('task.edit', ['task' => $task->id]) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mr-2">{{ __('Edit') }}</a>

            <div>
                <button x-data="" type="submit"
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete') }}</button>
            </div>
        </div>
    </div>


    {{-- Delete Confirmation Modal --}}
    <x-modal name="confirm-user-deletion" focusable>
        <form method="post" action="{{ route('task.destroy', ['task' => $task->id]) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this task?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Task') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
