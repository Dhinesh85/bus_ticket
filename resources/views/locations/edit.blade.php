<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit - Location
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-3 lg:px-8" style="background-color: transparent; border: 3px solid wheat; border-radius: 20px;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">
                
                <!-- Back Button -->
                <a href="{{ route('location.index') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25" style="margin-left: 100px;">
                    Go back
                </a>

                <!-- Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3">
                        <p><strong>Oops! Something went wrong:</strong></p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3">
                        <p class="text-sm text-danger">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('location.update', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- City -->
                    <div class="mb-4">
                        <label for="city" class="block mb-2 text-sm font-bold text-white">City <span class="text-red-600">*</span></label>
                        <input type="text" name="city" id="city" value="{{ old('city', $location->city) }}" required maxlength="100"
                            placeholder="Enter City name"
                            class="w-full px-3 py-2 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                        @error('city')
                            <span class="text-red-600 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- From -->
                    <div class="mb-4">
                        <label for="from" class="block mb-2 text-sm font-bold text-white">From <span class="text-red-600">*</span></label>
                        <input type="text" name="from" id="from" value="{{ old('from', $location->from) }}" required maxlength="100"
                            placeholder="Enter From"
                            class="w-full px-3 py-2 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                        @error('from')
                            <span class="text-red-600 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- To -->
                    <div class="mb-4">
                        <label for="to" class="block mb-2 text-sm font-bold text-white">To <span class="text-red-600">*</span></label>
                        <input type="text" name="to" id="to" value="{{ old('to', $location->to) }}" required maxlength="100"
                            placeholder="Enter To"
                            class="w-full px-3 py-2 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                        @error('to')
                            <span class="text-red-600 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Payment -->
                    <div class="mb-4">
                        <label for="payment" class="block mb-2 text-sm font-bold text-white">Payment <span class="text-red-600">*</span></label>
                        <input type="number" name="payment" id="payment" value="{{ old('payment', $location->payment) }}" required
                            placeholder="Enter amount"
                            class="w-full px-3 py-2 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                        @error('payment')
                            <span class="text-red-600 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Return Ticket Checkbox -->
                    <div class="mb-4 flex items-center space-x-3">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $location->is_active) ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-green-600 border-white focus:ring-white rounded-full" />
                        <label for="is_active" class="text-sm font-bold text-white ml-1">Return Ticket Available</label>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray">
                            Update
                        </button>
                    </div>
                </form>

                <!-- JS Logic for Return Ticket -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const checkbox = document.getElementById('is_active');
                        const paymentInput = document.getElementById('payment');
                        let originalPayment = paymentInput.value;

                        paymentInput.addEventListener('input', () => {
                            originalPayment = paymentInput.value;
                        });

                        checkbox.addEventListener('change', () => {
                            const val = parseFloat(originalPayment || paymentInput.value);
                            if (!isNaN(val)) {
                                paymentInput.value = checkbox.checked ? val * 2 : val / 2;
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
