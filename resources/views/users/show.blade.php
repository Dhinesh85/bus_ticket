<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show - User Details') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25"
            style="margin-left: 100px;">
           
                Go back
           
        </a>
    <div class="max-w-7xl mx-auto sm:px-3 lg:px-8" style="background-color: transparent; border: 3px solid wheat; border-radius: 20px;">
        <div class="bg-white shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">
            <div class="flex justify-between items-center border-b border-gray-300 mb-4">

                <div class="flex space-x-4">
                    <button type="button" onclick="showTab('profile')" id="btn-profile" class="tab-btn active-tab text-white">
                        Profile
                    </button>

                </div>


                <div class="flex space-x-2">


                    <!-- QR Code Button -->
                    <button id="qr-button" type="button"
                        class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md hover:bg-purple-500 active:bg-purple-700 focus:outline-none focus:border-purple-700 focus:shadow-outline-gray">
                        Show QR Code
                    </button>

                    @if($payment->payment_status == 'not_paid')
                    <button id="pay-button" type="button" class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-gray disabled:opacity-25" style="display: none;">
                        Pay Now
                    </button>
                    @endif

                </div>
            </div>

            <!-- Tabs content -->
            <div id="tab-profile" class="tab-content">

                <div class="flex items-center space-x-10">
                    <!-- Left: Profile Image -->
                    <div class="flex-shrink-0" style="margin-top: -25%;height: 200px;">
                        @if($user->profile_image)
                        <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}'s profile"
                            class="h-32 w-32 object-cover border-4 border-blue-500 shadow-md rounded-lg">
                        @else
                        <div class="h-32 w-32 bg-gray-300 flex items-center justify-center border-4 border-blue-500 shadow-md rounded-lg">
                            <!-- Default user SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A11.955 11.955 0 0112 15c2.21 0 4.295.635 6.004 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        @endif
                    </div><br>

                    <!-- Right: Name and Number in 2 columns -->
                    <div class="w-full" style="margin-left: 55px;">
                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="name" style="color: white;">Name</label>
                                    <input type="text" id="name" name="name" value="{{ $user->name }}"
                                        class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>
                                </div>

                                <!-- Phone (if you want to show email, adjust below) -->
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="phone" style="color: white;">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ $user->number ?? '' }}"
                                        class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>
                                </div>
                            </div><br>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="name" style="color: white;">email</label>
                                    <input type="text" id="name" name="name" value="{{ $user->email }}"
                                        class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>
                                </div>

                                <!-- Phone (if you want to show email, adjust below) -->
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="phone" style="color: white;">Aadhaar</label>
                                    <input type="text" id="phone" name="phone" value="{{ $user->aadhaar ?? '' }}"
                                        class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>
                                </div>
                            </div><br>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="name" style="color: white;">Amount</label>
                                    <input type="text" id="name" name="name" value="{{ $payment->payment_amount }}"
                                        class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="name" style="color: white;">Payment Method</label>
                                    <input type="text" id="name" name="name" value="{{ $payment->payment_method }}"
                                        class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>
                                </div>
                            </div><br>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="name" style="color: white;">Start Date</label>
                                    <input type="text" id="name" name="name" value="{{ $userLocation->start_date }}"
                                        class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>
                                </div>

                                <!-- Phone (if you want to show email, adjust below) -->
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="phone" style="color: white;">End Date</label>
                                    <input type="text" id="phone" name="phone" value="{{ $userLocation->end_date ?? '' }}"
                                        class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                        style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>
                                </div>
                            </div><br>
                            <div class="mt-6">
                                <label class="block text-gray-700 font-bold mb-2" for="address" style="color: white;">Address</label>
                                <textarea id="address" name="address" rows="3"
                                    class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;" readonly disabled>{{ $user->address ?? '' }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="name" style="color: white;">Pay Date</label>
                                    <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-green-500 rounded-full" style="border: 2px solid white">
                                        {{ $payment->payment_date }}
                                    </span>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-bold mb-2" for="phone" style="color: white;">Status</label>
                                    @if($payment->payment_status == 'paid')
                                    <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-green-500 rounded-full" style="border: 2px solid white">
                                        Active
                                    </span>
                                    @else
                                    <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-red-500 rounded-full" style="border: 2px solid white">
                                        Inactive
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- QR Code Modal -->
            <div id="qr-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Bus Pass QR Code</h3>
                        <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-col items-center">
                        <div id="qrcode-container" class="flex justify-center mb-4"></div>
                        <p class="text-sm text-gray-600 mb-4">Scan this QR code to view your bus pass details</p>
                        <p class="text-xs text-gray-500">Valid from {{ $userLocation->start_date }} to {{ $userLocation->end_date }}</p>

                        @if($payment->payment_status == 'paid')
                        <div class="mt-4 bg-green-100 p-2 rounded text-center">
                            <p class="text-green-700 font-medium">ACTIVE</p>
                        </div>
                        @else
                        <div class="mt-4 bg-red-100 p-2 rounded text-center">
                            <p class="text-red-700 font-medium">INACTIVE</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
            <script>
                function showTab(tabName) {
                    document.getElementById('tab-profile').classList.add('hidden');
                    document.getElementById('tab-payment').classList.add('hidden');
                    document.getElementById('btn-profile').classList.remove('active-tab');
                    document.getElementById('btn-payment').classList.remove('active-tab');

                    document.getElementById('tab-' + tabName).classList.remove('hidden');
                    document.getElementById('btn-' + tabName).classList.add('active-tab');
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const qrButton = document.getElementById('qr-button');
                    const qrModal = document.getElementById('qr-modal');
                    const closeModal = document.getElementById('close-modal');
                    const qrcodeContainer = document.getElementById('qrcode-container');

                    // Create the QR code data from user info
                    function generateQRCode() {
                        // Create an object with all the bus pass data
                        const passData = {
                            id: '{{ Auth::user()->id }}',
                            name: '{{ $user->name }}',
                            email: '{{ $user->email }}',
                            phone: '{{ $user->number ?? "N/A" }}',
                            aadhaar: '{{ $user->aadhaar ?? "N/A" }}',
                            start_date: '{{ $userLocation->start_date }}',
                            end_date: '{{ $userLocation->end_date }}',
                            payment_status: '{{ $payment->payment_status }}',
                            payment_date: '{{ $payment->payment_date }}',
                            payment_amount: '{{ $payment->payment_amount }}'
                        };

                        // Convert to JSON string
                        const passDataString = JSON.stringify(passData);

                        // Generate QR code
                        const qr = qrcode(0, 'L');
                        qr.addData(passDataString);
                        qr.make();

                        // Clear previous QR code if any
                        qrcodeContainer.innerHTML = '';

                        // Create and append the QR code image
                        const qrImage = qr.createImgTag(5, 0);
                        qrcodeContainer.innerHTML = qrImage;
                    }

                    // Show modal and generate QR code
                    qrButton.addEventListener('click', function() {
                        qrModal.classList.remove('hidden');
                        generateQRCode();
                    });

                    // Close modal
                    closeModal.addEventListener('click', function() {
                        qrModal.classList.add('hidden');
                    });

                    // Close modal when clicking outside
                    window.addEventListener('click', function(event) {
                        if (event.target === qrModal) {
                            qrModal.classList.add('hidden');
                        }
                    });
                });
            </script>

            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var payButton = document.getElementById('pay-button');

                    // Check if payment is unpaid, then show the pay button
                    @if($payment -> payment_status != 'paid')
                    payButton.style.display = 'inline-flex';
                    @endif

                    payButton.addEventListener('click', function(e) {
                        e.preventDefault();

                        var options = {
                            "key": "rzp_test_9rbMunIeD8GRCj", // Razorpay Key ID
                            "amount": "{{ ($payment->payment_amount ?? 0) * 100 }}", // Razorpay expects amount in paise
                            "currency": "INR",
                            "name": "{{ $user->name }}",
                            "description": "Payment for Service",
                            "image": "{{ Storage::url($user->profile_image ?? '') }}", // Optional
                            "handler": function(response) {
                                alert("Payment successful! Razorpay Payment ID: " + response.razorpay_payment_id);
                                // TODO: Send the payment ID to your server via AJAX and update the database
                            },
                            "prefill": {
                                "name": "{{ $user->name }}",
                                "email": "{{ $user->email }}",
                                "contact": "{{ $user->number }}"
                            },
                            "theme": {
                                "color": "#3399cc"
                            }
                        };
                        var rzp = new Razorpay(options);
                        rzp.open();
                    });
                });
            </script>
        </div>
    </div>
    </div>
</x-app-layout>