<x-app-layout>

    <x-slot:title>
        {{ __('Edit Task') }}
    </x-slot>

    <div class="max-w-2xl mx-auto my-8 p-4 bg-white shadow rounded-lg">

        <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Edit Task') }}</h1>

        <form action="{{ route('task.update', ['task' => $task->id]) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $task->title)"
                    required />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <div class="mb-4">
                <x-input-label for="editor" :value="__('Description')" />
                <x-textarea name="description" id="editor"
                    required>{{ old('description', $task->description) }}</x-textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div class="mb-4">
                <x-input-label for="status" :value="__('Status')" />
                <x-select name="status" id="status" required>
                    <x-option>{{ __('Select Option') }}</x-option>
                    @props(['selected', 'value'])
                    <x-option value="pending" class="p-2" :selected="old('status', $task->status) === 'pending' ? 'selected' : null">{{ __('Pending') }}</x-option>
                    <x-option value="completed" class="p-2" :selected="old('status', $task->status) === 'completed' ? 'selected' : null">{{ __('Completed') }}</x-option>
                </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('status')" />
            </div>

            <div class="mb-4">
                <x-input-label for="due_date" :value="__('Due Date')" />
                <x-text-input id="due_date" name="due_date" type="date" min="{{ now()->toDateString() }}"
                    class="mt-1 block w-full" :value="old('due_date', Carbon\Carbon::parse($task->due_date)->toDateString())" required />
                <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
            </div>

            <div class="text-right">
                <x-primary-button>{{ __('Update Task') }}</x-primary-button>
            </div>
        </form>
    </div>


    @push('js')
        <script src="{{ asset('assets/js/editor.js') }}"></script>
    @endpush
</x-app-layout>
