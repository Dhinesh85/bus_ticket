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

    <div class="flex justify-between mb-4 mt-6">
        <a href="{{ route('users.index') }}"
           class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md hover:bg-gray-700"
           style="margin-left: 35%;">
            Go Back
        </a>

        <button id="openModalBtn"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md hover:bg-gray-700"
                style="margin-right: 35%;">
            Show
        </button>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 border-4 border-yellow-200 rounded-2xl">
            <div class="bg-transparent px-4 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div>
                        <p class="text-white text-lg">
                            {{ implode(', ', $user->getRoleNames()->toArray()) }}
                        </p>
                    </div>
                    <div class="text-center">
                        <div id="qrcode" class="inline-block border-2 border-gray-300 p-2"></div>
                        <p class="mt-2 text-white">Scan to view user info</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="userModal"
         class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white w-full max-w-3xl mx-auto rounded-3xl shadow-lg p-6 relative">

            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-700 hover:text-red-600 text-2xl font-bold">
                &times;
            </button>

            <h2 class="text-2xl font-bold mb-6 text-center">User Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold">Name</label>
                    <input type="text" value="{{ $user->name }}" class="w-full px-3 py-2 border rounded-xl" readonly>
                </div>
                <div>
                    <label class="text-sm font-semibold">Email</label>
                    <input type="text" value="{{ $user->email }}" class="w-full px-3 py-2 border rounded-xl" readonly>
                </div>
                <div>
                    <label class="text-sm font-semibold">Phone</label>
                    <input type="text" value="{{ $user->number }}" class="w-full px-3 py-2 border rounded-xl" readonly>
                </div>
                <div>
                    <label class="text-sm font-semibold">Role</label>
                    <input type="text" value="{{ $user->userrole->name }}" class="w-full px-3 py-2 border rounded-xl" readonly>
                </div>
                <div>
                    <label class="text-sm font-semibold">Address</label>
                    <input type="text" value="{{ $user->address }}" class="w-full px-3 py-2 border rounded-xl" readonly>
                </div>
                <div>
                    <label class="text-sm font-semibold">City</label>
                    <input type="text" value="{{ $user->userlocation->city }}" class="w-full px-3 py-2 border rounded-xl" readonly>
                </div>
                <div>
                    <label class="text-sm font-semibold">From</label>
                    <input type="text" value="{{ $user->userlocation->from }}" class="w-full px-3 py-2 border rounded-xl" readonly>
                </div>
                <div>
                    <label class="text-sm font-semibold">To</label>
                    <input type="text" value="{{ $user->userlocation->to }}" class="w-full px-3 py-2 border rounded-xl" readonly>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userData = @json($userInfoText);

            new QRCode(document.getElementById("qrcode"), {
                text: userData,
                width: 300,
                height: 300,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

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

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
