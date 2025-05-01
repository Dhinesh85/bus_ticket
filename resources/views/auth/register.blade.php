<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Aadhaar Number -->
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

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- OTP JavaScript -->
<script>
    document.getElementById('sendOtpBtn').addEventListener('click', function() {
        
        const otp = Math.floor(100000 + Math.random() * 900000);

        
        sessionStorage.setItem('generatedOtp', otp);

        
        navigator.clipboard.writeText(otp).then(function() {
            // If copy successful
            Swal.fire({
                title: 'OTP Sent!',
                html: `Your OTP is <strong>${otp}</strong> <br><small>(Auto-copied to clipboard)</small>`,
                icon: 'success',
                confirmButtonText: 'OK',
                toast: true,   // Enable toast style for SweetAlert
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
                toast: true,   // Enable toast style for SweetAlert
                position: 'top-end', // Show at top-right corner
                showConfirmButton: false, // Hide confirm button for toast
                timer: 3000, // Auto-close the toast after 3 seconds
            });
        });
    });
</script>


    <!-- Format Aadhaar Number -->
    <script>
        document.getElementById('aadhaar').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');  // Remove non-digit characters
            if (value.length > 12) {
                value = value.slice(0, 12);  // Limit length to 12 digits
            }
            e.target.value = value.replace(/(\d{4})(\d{4})(\d{4})/, '$1 $2 $3');  // Format with spaces
        });
    </script>
</x-guest-layout>
