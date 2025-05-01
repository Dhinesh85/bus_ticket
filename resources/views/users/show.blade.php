@php
$userInfoText =
"Name : {$user->name}\n" .
"Email : {$user->email}\n" .
"Phone : {$user->number}\n" .
"Role : {$user->userrole->name}\n" .
"Address : {$user->address}\n" .
"City : {$user->userlocation->city}\n" .
"From : {$user->userlocation->from}\n" .
"To : {$user->userlocation->to}";
@endphp


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show - User Details') }}
        </h2>
    </x-slot>
    <div class="flex justify-between mb-4" style="    margin-top: 25px;
    margin-bottom: -10px;">
        <!-- Go Back Button (Left) -->
        <a href="{{ route('users.index') }}"
            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25" style="margin-left: 35%;">
            Go Back
        </a>

        <!-- Show Button (Right) -->
        <button id="openModalBtn"  class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25" style="margin-right: 35%;">
            Show
        </button>

    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="background-color: transparent; border: 3px solid wheat; border-radius: 20px; max-width: fit-content;">
            <div class="bg-white shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-4">
                                <div class="card-header">
                                    <!-- Empty header or you can add something here -->
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <p>
                                                {{ implode(', ', $user->getRoleNames()->toArray()) }}
                                            </p>
                                        </div>
                                        <div class="col-md-4" style="text-align: center;">
                                            <!-- QR Code container with box styling -->
                                            <div id="qrcode" style="border: 3px solid #ccc; padding: 10px; box-sizing: border-box;"></div>
                                            <p class="mt-2" style="color: white;">Scan to view user info</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Include QR Code Library -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const userData = @json($userInfoText);

                        new QRCode(document.getElementById("qrcode"), {
                            text: userData,
                            width: 300, // Width of the QR code
                            height: 300, // Height of the QR code
                            colorDark: "#000000", // Set dark color to black
                            colorLight: "#ffffff", // Set light color (background) to white
                            correctLevel: QRCode.CorrectLevel.H // Higher error correction level
                        });
                    });
                </script>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <!-- Tailwind Modal -->
    <div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white w-full max-w-2xl mx-auto rounded-xl shadow-lg p-6 relative" style="width: 80%;
    background-color: white;
    border: 2px solid white;
    border-radius: 50px">

            <!-- Close Button -->
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-700 hover:text-red-600 text-2xl font-bold">
                &times;
            </button>

            <!-- Modal Title -->
            <h2 class="text-2xl font-bold mb-6 text-center">User Information</h2>

            <!-- User Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold">Name</label>
                    <input type="text" value="{{ $user->name }}" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: black;" readonly disabled>
                </div>
                <div>
                    <label class="text-sm font-semibold">Email</label>
                    <input type="text" value="{{ $user->email }}" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: black;" readonly disabled>
                </div>
                <div>
                    <label class="text-sm font-semibold">Phone</label>
                    <input type="text" value="{{ $user->number }}" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: black;" readonly disabled>
                </div>
                <div>
                    <label class="text-sm font-semibold">Role</label>
                    <input type="text" value="{{ $user->userrole->name }}" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: black;" readonly disabled>
                </div>
                <div>
                    <label class="text-sm font-semibold">Address</label>
                    <input type="text" value="{{ $user->address }}" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: black;" readonly disabled>
                </div>
                <div>
                    <label class="text-sm font-semibold">City</label>
                    <input type="text" value="{{ $user->userlocation->city }}" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: black;" readonly disabled>
                </div>
                <div>
                    <label class="text-sm font-semibold">From</label>
                    <input type="text" value="{{ $user->userlocation->from }}" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: black;" readonly disabled>
                </div>
                <div>
                    <label class="text-sm font-semibold">To</label>
                    <input type="text" value="{{ $user->userlocation->to }}" class="w-full px-3 py-2 leading-tight border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: black;" readonly disabled>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modal = document.getElementById('userModal');

            openModalBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            closeModalBtn.addEventListener('click', () => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });

            // Optional: close when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });
        });
    </script>



</x-app-layout>