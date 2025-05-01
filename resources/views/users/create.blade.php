<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="color: white;">
            {{ __('Create - User') }}
        </h2>

    </x-slot>

    <div class="py-8">
        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25" style="color: white;">
            <button   class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25"
            style="margin-left: 100px;">
                Go back
            </button>
        </a>
        <form id="user-create-form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex space-x-4" style="margin: 5px;">

                <!-- Left Box -->
                <div style="background-color: transparent; border: 3px solid wheat; border-radius: 20px; max-width: 100%; width: 30%; margin-right: inherit;margin-left: 75px;">
                    <div title="back" class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">

                        <span class="text-2xl font-bold text-gray-800 mb-4" style="color: white;font-family: sans-serif;text-shadow: burlywood;font-size: larger;">Person Details</span>
                        <hr><br>

                        <div class="mb-4">
                            <label for="textname" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">Name <span class="text-red-600">*</span></label>
                            <input type="text" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="name" placeholder="Enter name" value="{{ old('name') }}" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>


                        <div class="mb-4">
                            <label for="textemail" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">Email <span class="text-red-600">*</span></label>
                            <input type="text" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="email" placeholder="Enter email" value="{{ old('email') }}" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                            @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="number" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">
                                Number <span class="text-red-600">*</span>
                            </label>
                            <input
                                type="tel"
                                name="number"
                                pattern="[0-9]{10}"
                                maxlength="10"
                                inputmode="numeric"
                                placeholder="Enter number"
                                class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                required
                                style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                            @error('number')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">Address <span class="text-red-600">*</span></label>
                            <textarea name="address" id="address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">{{ old('address') }}</textarea>
                            @error('address') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                        @php
                        $user = Auth::user()->role_id;
                        @endphp

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">
                                Profile Image <span class="text-red-600">*</span>
                            </label>

                            <!-- Drop Zone (initially visible) -->
                            <div id="dropZone" class="flex flex-col items-center justify-center w-full p-4 border-2 border-dashed border-white rounded-lg cursor-pointer hover:bg-white/10 transition" style="border:2px solid white;">
                                <p class="text-white text-center">Drag & drop your profile image here<br>or click to select</p>
                                <input type="file" name="profile_image" id="profileInput" accept="image/*" class="hidden" required>
                            </div>

                            <!-- Image Preview (initially hidden) -->
                            <div id="imagePreviewContainer" class="mt-4 hidden text-center">
                                <img id="previewImage" class="w-32 h-32 rounded-full object-cover border-2 border-white mx-auto" />
                                <button type="button" id="removeImage" class="mt-2 text-sm text-red-500 hover:underline">Remove Image</button>
                            </div>

                            @error('profile_image') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="textpassword" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">Password <span class="text-red-600">*</span></label>
                            <input type="password" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="password" placeholder="Enter Password" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                            @error('password') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="textconfirmpassword" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">Confirm Password <span class="text-red-600">*</span></label>
                            <input type="password" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="password_confirmation" placeholder="Enter Confirm Password" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                            @error('password_confirmation') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Box -->
                <div style="background-color: transparent; border: 3px solid wheat; border-radius: 20px; max-width: 100%; width: 30%;margin-right: inherit;">
                    <div title="back" class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">

                        <span class="text-2xl font-bold text-gray-800 mb-4" style="color: white;font-family: sans-serif;text-shadow: burlywood;font-size: larger;">Location Details</span>
                        <hr><br>

                        @if ($user == 1)
                        <div class="mb-4">
                            <label for="textrole" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">
                                Select Roles <span class="text-red-600">*</span>
                            </label>

                            <select name="role_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                                <option disabled selected>Choose a role</option>

                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>

                            @error('role_id')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif

                        <!-- Select City -->
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-white">Select City <span class="text-red-600">*</span></label>
                            <select name="city" id="city-select" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Choose a City</option>
                                @foreach ($cities as $cityName => $forms)
                                <option value="{{ $cityName }}">{{ $cityName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select Form (from origin) -->
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-white">Select Form <span class="text-red-600">*</span></label>
                            <select name="from" id="form-select" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Select Form</option>
                            </select>
                        </div>

                        <!-- To Country -->
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-white">To <span class="text-red-600">*</span></label>
                            <select name="to_" id="to-country-select" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Select To Country</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-sm font-bold">
                                <span class="text-red-600"> Payment is only valid for 30 days between the start and end date.</span>
                            </h3>
                        </div>

                        <div class="mb-4">
                            <label for="start_date" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">Start Date <span class="text-red-600">*</span></label>
                            <input type="date" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="start_date" placeholder="Enter Start Date" value="{{ old('start_date') }}" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                            @error('start_date') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="end_date" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">End Date <span class="text-red-600">*</span></label>
                            <input type="date" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="end_date" placeholder="Enter End Date" value="{{ old('end_date') }}" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                            @error('end_date') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>


                        <div class="mb-4">
                            <label for="payment" class="block mb-2 text-sm font-bold text-white">Daily Payment Rate</label>
                            <input
                                type="number"
                                id="payment"
                                name="daily_rate"
                                class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                placeholder="Enter amount"
                                required
                                readonly
                                style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                        </div>

                    </div>
                </div>

                <!-- Payment Section -->
                <div style="background-color: transparent; border: 3px solid wheat; border-radius: 20px; max-width: 100%; width: 30%;">
                    <div title="back" class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">
                        <span class="text-2xl font-bold text-gray-800 mb-4" style="color: white;font-family: sans-serif;text-shadow: burlywood;font-size: larger;">Payment</span>
                        <hr><br>
                        <div class="mt-4">
                            <x-input-label for="aadhaar" :value="__('Aadhaar Number')" />
                            <x-text-input id="aadhaar" class="block mt-1 w-full" type="text" name="aadhaar" :value="old('aadhaar')" required maxlength="14" minlength="14" pattern="\d{4} \d{4} \d{4}" title="Enter Aadhaar in the format: 1234 5678 9012" />
                            <x-input-error :messages="$errors->get('aadhaar')" class="mt-2" />
                        </div>

                        <!-- Send OTP Button -->
                        <div class="mt-2">
                            <button type="button" id="sendOtpBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Send OTP
                            </button>
                        </div>

                        <!-- OTP Field -->
                        <div class="mt-4">
                            <x-input-label for="otp" :value="__('Enter OTP')" />
                            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required />
                            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                        </div>



                        <div class="text-sm text-red-600 mt-2">
                            <strong>Cash Payment:</strong> Uses physical money, doesn't need internet, no automatic record, less secure.<br>
                            <strong>Online Payment:</strong> Uses digital methods (cards, UPI, etc.), needs internet, creates a digital record, more secure and traceable.<br>
                        </div><br>

                        <!-- Select Payment Method -->
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-white">Payment method <span class="text-red-600">*</span></label>
                            <select name="payment_method" id="payment-method-select" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Choose a Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="online">Online (Razorpay)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-white">Payment Status <span class="text-red-600">*</span></label>
                            <select name="payment_status" id="payment-status-select" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Choose a Payment Status</option>
                                <option value="paid">Paid</option>
                                <option value="not_paid">Not Paid</option>
                            </select>
                        </div>

                        @php
                        $today = \Carbon\Carbon::now()->toDateString();
                        @endphp

                        <div class="mb-4">
                            <label for="payment_date" class="block mb-2 text-sm font-bold text-gray-700" style="color: white;">
                                Payment Date<span class="text-red-600">*</span>
                            </label>
                            <input
                                type="date"
                                class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                name="payment_date"
                                placeholder=".."
                                value="{{ old('payment_date', $today) }}"
                                required
                                style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;"
                                min="{{ $today }}"
                                max="{{ $today }}">
                            @error('payment_date')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text-sm text-red-600 mt-2">
                            <strong>Note:</strong> Only full payment is allowed.
                        </div><br>
                        <div class="mb-4">
                            <label for="total_payment" class="block mb-2 text-sm font-bold text-white">Total Payment</label>
                            <input
                                type="text"
                                id="total_payment"
                                name="payment"
                                class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                readonly
                                style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                        </div>

                        <!-- Hidden fields for Razorpay -->
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">

                        <div class="flex space-x-2">
                            <button id="pay-button" type="button" class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-gray disabled:opacity-25" style="display: none;">
                                Pay Now
                            </button>

                            <button type="submit" id="button" class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                                Create User
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- OTP JavaScript -->
    <script>
        document.getElementById('sendOtpBtn').addEventListener('click', function() {
            // Generate a random 6-digit OTP
            const otp = Math.floor(100000 + Math.random() * 900000);

            // Save it in sessionStorage (temporary storage)
            sessionStorage.setItem('generatedOtp', otp);

            // Copy OTP to clipboard
            navigator.clipboard.writeText(otp).then(function() {
                // If copy successful
                Swal.fire({
                    title: 'OTP Sent!',
                    html: `Your OTP is <strong>${otp}</strong> <br><small>(Auto-copied to clipboard)</small>`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    toast: true, // Enable toast style for SweetAlert
                    position: 'top-end', // Show at top-right corner
                    showConfirmButton: false, // Hide confirm button for toast
                    timer: 3000, // Auto-close the toast after 3 seconds
                });
            }).catch(function() {
                // If copy failed
                Swal.fire({
                    title: 'OTP Sent!',
                    text: 'Your OTP is ' + otp,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    toast: true, // Enable toast style for SweetAlert
                    position: 'top-end', // Show at top-right corner
                    showConfirmButton: false, // Hide confirm button for toast
                    timer: 3000, // Auto-close the toast after 3 seconds
                });
            });
        });
    </script>


    <!-- Format Aadhaar Number -->
    <script>
        document.getElementById('aadhaar').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digit characters
            if (value.length > 12) {
                value = value.slice(0, 12); // Limit length to 12 digits
            }
            e.target.value = value.replace(/(\d{4})(\d{4})(\d{4})/, '$1 $2 $3'); // Format with spaces
        });
    </script>
    <!-- Razorpay Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile Image Handling
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('profileInput');
            const preview = document.getElementById('previewImage');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const removeBtn = document.getElementById('removeImage');

            // Open file picker on click
            dropZone.addEventListener('click', () => fileInput.click());

            // Handle file selection
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        previewContainer.classList.remove('hidden');
                        dropZone.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Drag & drop support
            ['dragenter', 'dragover'].forEach(evt =>
                dropZone.addEventListener(evt, e => {
                    e.preventDefault();
                    dropZone.classList.add('bg-white/10');
                })
            );

            ['dragleave', 'drop'].forEach(evt =>
                dropZone.addEventListener(evt, e => {
                    e.preventDefault();
                    dropZone.classList.remove('bg-white/10');
                })
            );

            dropZone.addEventListener('drop', e => {
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    fileInput.files = e.dataTransfer.files;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        previewContainer.classList.remove('hidden');
                        dropZone.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove image logic
            removeBtn.addEventListener('click', () => {
                fileInput.value = '';
                preview.src = '';
                previewContainer.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            // Date handling
            const startDateInput = document.querySelector('input[name="start_date"]');
            const endDateInput = document.querySelector('input[name="end_date"]');

            // Set today's date as minimum for start date
            const today = new Date().toISOString().split('T')[0];
            startDateInput.setAttribute('min', today);

            // When the start date is selected
            startDateInput.addEventListener('change', function() {
                const startDate = new Date(this.value);
                if (isNaN(startDate)) return;


                const minEndDate = new Date(startDate);
                const maxEndDate = new Date(startDate);
                maxEndDate.setDate(maxEndDate.getDate() + 29);


                const minEnd = minEndDate.toISOString().split('T')[0];
                const maxEnd = maxEndDate.toISOString().split('T')[0];


                endDateInput.removeAttribute('disabled');
                endDateInput.setAttribute('min', minEnd);
                endDateInput.setAttribute('max', maxEnd);


                endDateInput.value = maxEnd;


                calculateTotal();
            });


            endDateInput.setAttribute('disabled', true);


            const citySelect = document.getElementById('city-select');
            const formSelect = document.getElementById('form-select');
            const toSelect = document.getElementById('to-country-select');
            const paymentInput = document.getElementById('payment');
            const totalPaymentInput = document.getElementById('total_payment');
            const payButton = document.getElementById('pay-button');
            const paymentMethodSelect = document.getElementById('payment-method-select');
            const paymentStatusSelect = document.getElementById('payment-status-select');
            const form = document.getElementById('user-create-form');

            function calculateDays(start, end) {
                const startDate = new Date(start);
                const endDate = new Date(end);
                const diffTime = Math.abs(endDate - startDate);
                // Add 1 to include both start and end date
                return Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
            }

            function calculateTotal() {
                const start = startDateInput.value;
                const end = endDateInput.value;
                const dailyRate = parseFloat(paymentInput.value);

                if (start && end && !isNaN(dailyRate)) {
                    const days = calculateDays(start, end);
                    if (days >= 0) {
                        const total = days * dailyRate;
                        totalPaymentInput.value = total.toFixed(2);
                        updatePayButtonVisibility();
                    } else {
                        totalPaymentInput.value = '';
                    }
                } else {
                    totalPaymentInput.value = '';
                }
            }

            function updatePayButtonVisibility() {
                if (paymentMethodSelect.value === 'online' &&
                    paymentStatusSelect.value === 'paid' &&
                    totalPaymentInput.value) {
                    payButton.style.display = 'inline-flex';
                } else {
                    payButton.style.display = 'none';
                }
            }

            startDateInput.addEventListener('change', calculateTotal);
            endDateInput.addEventListener('change', calculateTotal);
            paymentMethodSelect.addEventListener('change', updatePayButtonVisibility);
            paymentStatusSelect.addEventListener('change', updatePayButtonVisibility);

            citySelect.addEventListener('change', function() {
                const city = this.value;
                formSelect.innerHTML = '<option selected disabled>Select Form</option>';
                toSelect.innerHTML = '<option selected disabled>Select To Country</option>';
                paymentInput.value = '';
                totalPaymentInput.value = '';

                fetch(`/get-forms-by-city?city=${encodeURIComponent(city)}`)
                    .then(res => res.json())
                    .then(forms => {
                        forms.forEach(form => {
                            const option = document.createElement('option');
                            option.value = form.id;
                            option.textContent = form.from;
                            formSelect.appendChild(option);
                        });
                    });
            });

            formSelect.addEventListener('change', function() {
                const formId = this.value;
                toSelect.innerHTML = '<option selected disabled>Select To Country</option>';
                paymentInput.value = '';
                totalPaymentInput.value = '';

                fetch(`/get-to-by-form?form_id=${formId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.to_id && data.to_name) {
                            const option = document.createElement('option');
                            option.value = data.to_id;
                            option.textContent = data.to_name;
                            toSelect.appendChild(option);
                        }
                    });
            });

            toSelect.addEventListener('change', function() {
                const toId = this.value;
                fetch(`/get-payment-by-to?to_id=${toId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.payment !== null) {
                            paymentInput.value = parseFloat(data.payment).toFixed(2);
                            calculateTotal();
                        } else {
                            paymentInput.value = '';
                            totalPaymentInput.value = '';
                        }
                    });
            });

            // Handle form submission validation
            form.addEventListener('submit', function(e) {
                // Validate payment method
                if (paymentMethodSelect.value === 'online' &&
                    paymentStatusSelect.value === 'paid' &&
                    !document.getElementById('razorpay_payment_id').value) {
                    e.preventDefault();
                    alert('Please complete the online payment before submitting the form.');
                }
            });

            // Razorpay Payment Handler
            payButton.onclick = function(e) {
                e.preventDefault();

                const nameInput = document.querySelector('input[name="name"]');
                const emailInput = document.querySelector('input[name="email"]');
                const numberInput = document.querySelector('input[name="number"]');

                // Convert amount to paise (multiply by 100)
                const amount = parseFloat(totalPaymentInput.value) * 100;

                var options = {
                    "key": "rzp_test_9rbMunIeD8GRCj", // Replace with your actual Razorpay key
                    "amount": amount,
                    "currency": "INR",
                    "name": "Sky Pass",
                    "description": "Payment for User Registration",
                    "handler": function(response) {
                        // Store payment IDs in hidden fields
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id || '';

                        // Show success message
                        alert("Payment Successful! Reference ID: " + response.razorpay_payment_id);

                        // Update button states
                        payButton.textContent = "Payment Completed";
                        payButton.disabled = true;
                        payButton.classList.add('bg-gray-400');
                        payButton.classList.remove('bg-blue-600', 'hover:bg-blue-500');
                    },
                    "prefill": {
                        "name": nameInput.value || "Customer Name",
                        "email": emailInput.value || "customer@example.com",
                        "contact": numberInput.value || ""
                    },
                    "theme": {
                        "color": "#1F2937"
                    }
                };

                var rzp1 = new Razorpay(options);
                rzp1.open();
            };
        });
    </script>
</x-app-layout>