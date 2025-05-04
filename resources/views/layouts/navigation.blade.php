<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    @php
    $roleId = Auth::user()->role_id;

    $role_permissions = DB::table('role_has_permissions')
    ->where('role_id', $roleId)
    ->pluck('permission_id');

    $permissions = DB::table('permissions')
    ->whereIn('id', $role_permissions)
    ->get();
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Dashboard -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <!-- Permission-based links -->
                @if($permissions->contains('name', 'Users'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        Users
                    </x-nav-link>
                </div>
                @endif



                @if($permissions->contains('name', 'Role and Permission'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                        Role and Permission
                    </x-nav-link>
                </div>
                @endif

                @if($permissions->contains('name', 'Location'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('location.index')" :active="request()->routeIs('Location.*')">
                        Location
                    </x-nav-link>
                </div>
                @endif

                @if($permissions->contains('name', 'Chat Box'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('chat.index')" :active="request()->routeIs('Chat Box.*')">
                        Chat Box
                    </x-nav-link>
                </div>
                @endif

                @if(Auth::user()->role_id == 1)
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :active="request()->routeIs('Chat Box.*')" id="openModal">
                        Scan QR Code

                    </x-nav-link>
                </div>
                @endif

                <div id="qrModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
                        <!-- Close button -->
                        <button id="closeModal" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-red-500 text-xl font-bold">&times;</button>

                        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">QR Code Scanner</h2>

                        <!-- Scanner Container -->
                        <div id="qr-reader" class="border border-gray-300 dark:border-gray-700"></div>

                        <!-- Spinner for loading -->
                        <div id="scanner-loading" class="hidden mt-4 text-center">
                            <i class="fas fa-spinner fa-spin text-blue-500"></i>
                            <span class="ml-2 text-gray-600 dark:text-gray-300">Starting camera...</span>
                        </div>

                        <!-- Results Display Area -->
                        <div id="qr-result" class="mt-4 hidden">
                            <div class="font-medium text-gray-700 dark:text-gray-300">
                                <p class="mb-2">Scan Result:</p>
                                <div id="scan-result-value" class="p-2 bg-gray-100 dark:bg-gray-700 rounded"></div>
                            </div>

                            <!-- Ticket Checkbox Container -->
                            <div class="ticket-checkbox-container mt-3">
                                <input
                                    type="checkbox"
                                    name="is_ticket_available"
                                    id="is_ticket_available"
                                    value="1"
                                    class="form-checkbox h-5 w-5 text-blue-600 border-gray-300 rounded-sm focus:ring-blue-500" />
                                <label for="is_ticket_available" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Return Ticket Available
                                </label>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between mt-4">
                                <button id="scan-again" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                    <i class="fas fa-redo-alt mr-1"></i> Scan Again
                                </button>
                                <button id="process-ticket" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                    <i class="fas fa-check mr-1"></i> Process Ticket
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Include the jsQR library for QR code scanning -->
                <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
                <script src="https://cdn.tailwindcss.com"></script>

                <!-- jQuery -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <!-- Html5 QR Code -->
                <script src="https://unpkg.com/html5-qrcode"></script>


            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Nav -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive User Info -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<script>
    let scanner = null;
    let scanResult = null;

    // Modal Open Button
    $('#openModal').click(function() {
        $('#qrModal').removeClass('hidden');
        $('#scanner-loading').removeClass('hidden');
        $('#qr-result').addClass('hidden');

        // Start scanner with short delay for modal animation
        setTimeout(startScanner, 300);
    });

    // Close Modal Button
    $('#closeModal').click(function() {
        closeModal();
    });

    // Scan Again Button
    $('#scan-again').click(function() {
        // Hide result and start scanner again
        $('#qr-result').addClass('hidden');
        $('#scanner-loading').removeClass('hidden');
        startScanner();
    });

    // Process Ticket Button
    $('#process-ticket').click(function() {
        if (scanResult) {
            const ticketAvailable = $('#is_ticket_available').is(':checked');

            // Here you would typically send this data to your backend
            // For demo purposes, we'll just show an alert
            alert(`Processing ticket: ${scanResult}\nReturn ticket available: ${ticketAvailable ? 'Yes' : 'No'}`);

            // Close modal after processing
            closeModal();
        }
    });

    // Start QR Scanner Function
    function startScanner() {
        // Clear previous instances
        if (scanner) {
            scanner.clear();
        }

        scanner = new Html5Qrcode("qr-reader");

        const config = {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            },
            aspectRatio: 1.0
        };

        // Start scanner
        scanner.start({
                facingMode: "environment"
            },
            config,
            onScanSuccess,
            onScanFailure
        ).then(() => {
            // Scanner started successfully
            $('#scanner-loading').addClass('hidden');
        }).catch(err => {
            console.error(`Scanner error: ${err}`);
            $('#scanner-loading').addClass('hidden');
            $('#qr-reader').html(`<div class="p-4 text-red-500">Camera access error: ${err.message || 'Unknown error'}</div>`);
        });
    }

    // QR Scan Success Handler
    function onScanSuccess(qrCodeMessage) {
        // Store the result
        scanResult = qrCodeMessage;

        // Stop scanner
        if (scanner) {
            scanner.stop().then(() => {
                console.log("Scanner stopped");
            }).catch(err => {
                console.error("Failed to stop scanner:", err);
            });
        }

        // Display result
        $('#scan-result-value').text(qrCodeMessage);
        $('#qr-result').removeClass('hidden').addClass('scan-result-success');

        // Reset checkbox
        $('#is_ticket_available').prop('checked', false);
    }

    // QR Scan Failure Handler
    function onScanFailure(error) {
        // We don't need to log every failure as it happens continuously until success
        // console.error(`QR scan error: ${error}`);
    }

    // Close Modal Function
    function closeModal() {
        // Stop scanner if running
        if (scanner) {
            scanner.stop().then(() => {
                $('#qr-reader').html("");
            }).catch(err => {
                console.error("Failed to stop scanner:", err);
            });
        }

        // Hide modal
        $('#qrModal').addClass('hidden');

        // Reset state
        scanResult = null;
    }
</script>