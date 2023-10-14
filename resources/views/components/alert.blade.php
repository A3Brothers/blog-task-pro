@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mt-1 mb-1"
        id="success_div">
        <div class="flex items-center justify-between">
            <div>{{ session('success') }}</div>
            <button class="p-2 text-green-700 hover:text-green-900 focus:outline-none"
                onclick="document.getElementById('success_div').style.display = 'none'">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M5.293 5.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 111.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z" />
                </svg>
            </button>
        </div>
    </div>
@elseif (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mt-1 mb-1" id="error_div">
        <div class="flex items-center justify-between">
            <div>{{ session('error') }}</div>
            <button class="p-2 text-red-700 hover:text-red-900 focus:outline-none"
                onclick="document.getElementById('error_div').style.display = 'none'">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M5.293 5.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 111.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z" />
                </svg>
            </button>
        </div>
    </div>
@endif
