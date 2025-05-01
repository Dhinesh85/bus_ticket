<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @php
    $userIds = DB::table('users')->pluck('id');
    $totalUsers = DB::table('users')->count();

    $activeUsers = DB::table('payments')
    ->whereIn('user_id', $userIds)
    ->where('payment_status', 'paid')
    ->distinct('user_id')
    ->count('user_id');

    $deactiveUsers = DB::table('payments')
    ->whereIn('user_id', $userIds)
    ->where('payment_status', 'not_paid')
    ->distinct('user_id')
    ->count('user_id');

    $totalPaymentAmount = DB::table('payments')
    ->whereIn('user_id', $userIds)
    ->where('payment_status', 'paid')
    ->sum('payment_amount');

    $PaymentAmount = DB::table('payments')
    ->whereIn('user_id', $userIds)
    ->where('payment_status', 'not_paid')
    ->sum('payment_amount');
    @endphp

    @if(Auth::user()->role_id == 1)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap lg:flex-nowrap gap-6">

                <!-- Left: Chart -->
                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">User Statistics</h3>
                    <canvas id="userChart" height="120"></canvas>
                </div>

                <!-- Right: Calendar -->
                <div class="flex-1">
                    <!-- Full-width calendar container -->
                    <div class="w-full flex justify-center">
                        <div id="calendar" class="w-full"></div>
                    </div><br>
                    <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center">
                            <!-- Left: Increment -->
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-sort-up text-green-500 text-2xl" style="color: white;font-size: x-large;"></i>
                                <p class="text-xl text-gray-900 dark:text-white" style="margin-left: 10px;">
                                    {{ number_format($totalPaymentAmount, 2) }} 
                                </p>
                            </div>

                            <!-- Right: Decrement -->
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-sort-down text-red-500 text-2xl" style="color: white;font-size: x-large;"></i>
                                <p class="text-xl text-gray-900 dark:text-white" style="margin-left: 10px;">
                                    {{ number_format($PaymentAmount, 2) }} 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(Auth::user()->role_id == 3)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-6">

                <!-- Left: Chart -->
                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">User Statistics</h3>
                    <canvas id="userChart" height="120"></canvas>
                </div>

                <!-- Right: Smaller Calendar -->
                <div class="flex-1">
                    <!-- Smaller calendar container -->
                    <div class="w-full flex justify-center">
                        <div id="calendar" class="w-full" style="max-width: 350px;"></div>
                    </div><br>
                    <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center">
                            <!-- Left: Increment -->
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-sort-up text-green-500 text-2xl" style="color: white;font-size: x-large;"></i>
                                <p class="text-xl text-gray-900 dark:text-white" style="margin-left: 10px;">
                                    {{ number_format($totalPaymentAmount, 2) }} 
                                </p>
                            </div>

                            <!-- Right: Decrement -->
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-sort-down text-red-500 text-2xl" style="color: white;font-size: x-large;"></i>
                                <p class="text-xl text-gray-900 dark:text-white" style="margin-left: 10px;">
                                    {{ number_format($PaymentAmount, 2) }} 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        /* Calendar styles optimized for dark mode */
        .flatpickr-calendar {
            background-color: #1F2937 !important;
            /* Dark background */
            border: 1px solid #374151 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            color: #ffffff !important;
            width: 100% !important;
            /* Force full width */
        }

        /* Calendar components */
        .flatpickr-months {
            background-color: #111827 !important;
            color: #ffffff !important;
        }

        .flatpickr-month,
        .flatpickr-current-month,
        .flatpickr-monthDropdown-months,
        .flatpickr-weekday,
        .flatpickr-weekdays,
        .flatpickr-innerContainer {
            background-color: transparent !important;
            color: #ffffff !important;
        }

        .flatpickr-day {
            color: #D1D5DB !important;
            border-radius: 4px !important;
        }

        .flatpickr-day.today {
            background-color: #10B981 !important;
            color: #ffffff !important;
            border-radius: 50% !important;
        }

        /* Disable all dates except for today */
        .flatpickr-day:not(.today) {
            pointer-events: none !important;
            color: #6B7280 !important;
        }

        /* Fix for inline calendar display */
        .flatpickr-calendar.animate.inline {
            width: 100% !important;
            max-width: 320px !important;
        }

        /* Navigation arrows */
        .flatpickr-prev-month,
        .flatpickr-next-month {
            fill: #ffffff !important;
        }

        .flatpickr-prev-month:hover svg,
        .flatpickr-next-month:hover svg {
            fill: #10B981 !important;
        }
    </style>

    <script>
        // Inject the PHP variables into JavaScript
        const totalUsers = @json($totalUsers);
        const activeUsers = @json($activeUsers);
        const deactiveUsers = @json($deactiveUsers);

        // Chart.js Initialization
        const ctx = document.getElementById('userChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Users', 'Active Users', 'Deactive Users'],
                datasets: [{
                    label: 'User Count',
                    data: [totalUsers, activeUsers, deactiveUsers],
                    backgroundColor: ['#3B82F6', '#10B981', '#EF4444'],
                    borderColor: ['#2563EB', '#059669', '#DC2626'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#ffffff'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                }
            }
        });

        // Flatpickr Calendar Initialization
        flatpickr("#calendar", {
            inline: true,
            disableMobile: true,
            static: true, // Keeps the calendar open
            defaultDate: "today"
        });

        // Make sure the calendar is properly sized after page load
        window.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 500);
        });
    </script>
</x-app-layout>
