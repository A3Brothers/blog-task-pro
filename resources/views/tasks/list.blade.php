<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Task List') }}
        </h2>
    </x-slot>

    <div class="text-right m-8">
        <a href="{{ route('task.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 text-right">
            Add Task +
        </a>
    </div>
    <div class="w-full mx-auto my-8 p-4 bg-white shadow rounded-lg px-20">
        <div class="-mx-4 -my-2 overflow-x-auto">
            <table class="w-full bg-white border border-gray-200 mx-auto task_datatable">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Title') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Description') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Due Date') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('View') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Datatable Content -->
                </tbody>
            </table>
        </div>
    </div>


    @push('js')
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script type="text/javascript">
            $(function() {
                var table = $('.task_datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('task.index') }}",
                    columns: [{
                            data: 'index',
                            name: 'index',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'title',
                            name: 'title',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'description',
                            name: 'description',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'due_date',
                            name: 'due_date',
                            orderable: true,
                            searchable: false
                        },
                        {
                            data: 'view',
                            name: 'view',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    order: [
                        [4, 'desc']
                    ]
                });
            });
        </script>
    @endpush

</x-app-layout>
