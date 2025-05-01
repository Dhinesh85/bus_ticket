<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create - Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-3 lg:px-8" style="background-color: transparent; border: 3px solid wheat; border-radius: 20px;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">

                <!-- Back Button -->
                <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25"
                style="margin-left: 100px;">                        Go back
                  
                </a>
                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                    <p><strong>Oops! Something went wrong:</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Session Error -->
                @if (session('error'))
                <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                    <p class="text-sm text-danger">{{ session('error') }}</p>
                </div>
                @endif

                <!-- Form Start -->
                <form action="{{ route('location.store') }}" method="POST">
                    @csrf

                    <!-- City Name -->
                    <div class="mb-4">
                        <label for="city" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">
                            City <span class="text-red-600">*</span>
                        </label>


                        <input type="text" name="city" id="city" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="name" placeholder="Enter name" value="{{ old('name') }}" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" placeholder="Enter City name"
                            maxlength="100" value="{{ old('city') }}" required>
                        @error('city')
                        <span class="text-red-600 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- From -->
                    <div class="mb-4">
                        <label for="from" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">
                            From<span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="from" id="from" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="name" placeholder="Enter name" value="{{ old('name') }}" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;"
                            maxlength="100" value="{{ old('from') }}" required>
                        @error('from')
                        <span class="text-red-600 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- To -->
                    <div class="mb-4">
                        <label for="to" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">
                            To<span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="to" id="to" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="name" placeholder="Enter name" value="{{ old('name') }}" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;"
                            maxlength="100" value="{{ old('to') }}" required>
                        @error('to')
                        <span class="text-red-600 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Payment Field -->
                    <div class="mb-4">
                        <label for="payment" class="block mb-2 text-sm font-bold text-white">
                            Payment <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="number"
                            name="payment"
                            id="payment"
                            class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            placeholder="Enter amount"
                            value="{{ old('payment') }}"
                            required
                            style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                    </div>

                    <!-- Checkbox -->
                    <div class="mb-4 flex items-center space-x-3">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            value="1"
                            {{ old('is_active') ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-green-600 border-white focus:ring-white rounded-full" />
                        <label for="is_active" class="text-sm font-bold text-white"><span style="margin-left: 5px;"> Retrue Ticket Available</span></label>
                    </div>



                    <!-- Submit Button -->
                    <div>
                        <button title="save" type="submit"
                            class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
                            Save
                        </button>
                    </div>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkbox = document.getElementById('is_active');
                        const paymentInput = document.getElementById('payment');

                        let originalPayment = '';

                        paymentInput.addEventListener('input', () => {
                            originalPayment = paymentInput.value;
                        });

                        checkbox.addEventListener('change', () => {
                            const val = parseFloat(originalPayment || paymentInput.value);
                            if (!isNaN(val)) {
                                if (checkbox.checked) {
                                    paymentInput.value = val * 2;
                                } else {
                                    paymentInput.value = val;
                                }
                            }
                        });
                    });
                </script>

            </div>
        </div>
    </div>
</x-app-layout>