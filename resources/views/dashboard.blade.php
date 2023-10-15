<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight text-center my-6">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-full mx-auto p-4 flex flex-wrap justify-center items-center">
        <div class="w-full md:w-1/2 lg:w-1/4 p-4">
            <div class="bg-slate-800 text-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-2xl font-semibold mb-4">{{ __('Create a New Post') }}</h3>
                <a href="{{ route('post.create') }}"
                    class="bg-white text-blue-500 px-4 py-2 rounded-md hover:bg-blue-100 hover:text-blue-700">{{ __('Create
                                                                                                                                            Post') }}</a>
            </div>
        </div>

        <div class="w-full md:w-1/2 lg:w-1/4 p-4">
            <div class="bg-slate-800 text-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-2xl font-semibold mb-4">{{ __('View My Posts') }}</h3>
                <a href="{{ route('post.user.list') }}"
                    class="bg-white text-green-500 px-4 py-2 rounded-md hover:bg-green-100 hover:text-green-700">{{ __('View
                                                                                                                                            Posts') }}</a>
            </div>
        </div>

        <div class="w-full md:w-1/2 lg:w-1/4 p-4">
            <div class="bg-slate-800 text-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-2xl font-semibold mb-4">{{ __('Create a New Task') }}</h3>
                <a href="{{ route('task.create') }}"
                    class="bg-white text-yellow-500 px-4 py-2 rounded-md hover:bg-yellow-100 hover:text-yellow-700">{{ __('Create
                                                                                                                                            Task') }}</a>
            </div>
        </div>

        <div class="w-full md:w-1/2 lg:w-1/4 p-4">
            <div class="bg-slate-800 text-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-2xl font-semibold mb-4">{{ __('View My Tasks') }}</h3>
                <a href="{{ route('task.index') }}"
                    class="bg-white text-red-500 px-4 py-2 rounded-md hover:bg-red-100 hover:text-red-700">{{ __('View
                                                                                                                                            Tasks') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
