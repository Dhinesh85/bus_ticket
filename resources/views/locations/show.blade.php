<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show - Location') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                <!-- Back Button -->
                <a title="Back" href="{{ route('location.index') }}"
                   class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    {{ __('Back') }}
                </a>

                <!-- City -->
                <div class="mb-4">
                    <label for="city" class="block mb-2 text-sm font-bold text-gray-700">City:</label>
                    <input type="text" id="city" value="{{ $location->city }}" disabled
                           class="w-full px-3 py-2 border rounded shadow bg-gray-100 text-gray-700">
                </div>

                <!-- From -->
                <div class="mb-4">
                    <label for="from" class="block mb-2 text-sm font-bold text-gray-700">From:</label>
                    <input type="text" id="from" value="{{ $location->from }}" disabled
                           class="w-full px-3 py-2 border rounded shadow bg-gray-100 text-gray-700">
                </div>

                <!-- To -->
                <div class="mb-4">
                    <label for="to" class="block mb-2 text-sm font-bold text-gray-700">To:</label>
                    <input type="text" id="to" value="{{ $location->to }}" disabled
                           class="w-full px-3 py-2 border rounded shadow bg-gray-100 text-gray-700">
                </div>

                <!-- Payment -->
                <div class="mb-4">
                    <label for="payment" class="block mb-2 text-sm font-bold text-gray-700">Payment:</label>
                    <input type="text" id="payment" value="{{ $location->payment }}" disabled
                           class="w-full px-3 py-2 border rounded shadow bg-gray-100 text-gray-700">
                </div>

                <!-- Return Ticket Available -->
                <div class="mb-4">
                    <label for="is_active" class="block mb-2 text-sm font-bold text-gray-700">Return Ticket Available:</label>
                    <input type="text" id="is_active" value="{{ $location->is_active ? 'Yes' : 'No' }}" disabled
                           class="w-full px-3 py-2 border rounded shadow bg-gray-100 text-gray-700">
                </div>

                <!-- Add more fields if needed -->

            </div>
        </div>
    </div>
</x-app-layout>
