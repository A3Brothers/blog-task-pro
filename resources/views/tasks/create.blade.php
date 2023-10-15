<x-app-layout>

    <x-slot:title>
        {{ __('Create Task') }}
    </x-slot>

    <div class="max-w-2xl mx-auto my-8 p-4 bg-white shadow rounded-lg">

        <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Create Task') }}</h1>

        <form action="{{ route('task.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')"
                    required />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <div class="mb-4">
                <x-input-label for="editor" :value="__('Description')" />
                <x-textarea name="description" id="editor">{{ old('description') }}</x-textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div class="mb-4">
                <x-input-label for="status" :value="__('Status')" />
                <x-select name="status" id="status" required>
                    <x-option>{{ __('Select Option') }}</x-option>
                    <x-option value="pending" class="p-2" :selected="old('status') === 'pending' ? 'selected' : null">{{ __('Pending') }}</x-option>
                    <x-option value="completed" class="p-2" :selected="old('status') === 'completed' ? 'selected' : null">{{ __('Completed') }}</x-option>
                </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('status')" />
            </div>

            <div class="mb-4">
                <x-input-label for="due_date" :value="__('Due Date')" />
                <x-text-input id="due_date" name="due_date" type="date" min="{{ now()->toDateString() }}"
                    class="mt-1 block w-full" :value="old('due_date')" required />
                <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
            </div>

            <div class="text-right">
                <x-primary-button>{{ __('Create Task') }}</x-primary-button>
            </div>
        </form>
    </div>


    @push('js')
        <script src="{{ asset('assets/js/editor.js') }}"></script>
    @endpush
</x-app-layout>
