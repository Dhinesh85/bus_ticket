@php
$userInfoText =
"Name : {$user->name}\n" .
"Email : {$user->email}\n" .
"Phone : {$user->number}\n" .
"Role : {$user->userrole->name}\n" .
"Address : {$user->address}\n" ;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <style>
        @media (max-width: 570px) {

            #active-users .overflow-auto,
            #inactive-users .overflow-auto {
                overflow-x: auto;
            }
        }

        /* Clean button styles with transparent backgrounds */
        .dt-button {
            background-color: transparent !important;
            color: white !important;
            border: 2px solid #2563eb;
            border-radius: 6px;
            margin: 2px;
            padding: 5px 10px;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        /* Change button background color on hover */
        .dt-button:hover {
            background-color: rgba(37, 99, 235, 0.2) !important;
            color: white !important;
        }

        /* Make sure icons maintain white color */
        .dt-button i {
            color: white !important;
        }

        /* Button collection styling */
        .dt-button-collection {
            display: flex;
        }

        .dt-button-collection .dt-button {
            padding: 0 !important;
            font-size: 16px;
        }

        /* DataTable Custom Styles */
        table.dataTable thead th,
        table.dataTable tbody td {
            color: white !important;
        }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate,
        .dataTables_wrapper .dataTables_length {
            color: white !important;
            margin: 8px 0;
        }

        /* Style for page length selector - hide label text */
        .dataTables_length label {
            font-size: 0;
            /* Hide the label text */
        }

        .dataTables_wrapper .dataTables_length select {
            font-size: 1rem;
            /* Restore font size for select */
            background-color: transparent !important;
            color: white;
            border: 1px solid #2563eb;
            border-radius: 4px;
            padding: 4px 8px;
            margin: 0 5px;
            margin-top: -10px;
            /* Added negative margin to adjust position */
        }

        /* Make option backgrounds dark for visibility */
        .dataTables_length select option {
            background-color: #1a202c;
            /* Dark background for dropdown options */
            color: white;
        }

        /* Style for pagination buttons */
        .dataTables_paginate .paginate_button {
            background-color: transparent !important;
            color: white !important;
            border: 1px solid #2563eb !important;
            border-radius: 4px;
            margin: 0 2px;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #2563eb !important;
            color: white !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: rgba(37, 99, 235, 0.2) !important;
            color: white !important;
        }

        /* Hide "Search:" label from DataTables filter */
        .dataTables_filter label {
            font-size: 0;
            /* Hide the label text */
        }

        .dataTables_filter input {
            font-size: 1rem;
            /* Restore the font size for the input */
            margin-left: 0 !important;
            /* Remove left margin */
            background-color: transparent;
            color: white;
            border: 1px solid #2563eb;
            border-radius: 4px;
            padding: 4px 8px;
        }

        /* Ensure placeholder is visible */
        .dataTables_filter input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Tab button styles */
        .tab-button {
            transition: all 0.3s ease;
        }

        .tab-button.active {
            background-color: #2563eb;
            color: white;
        }
    </style>

    {{-- Include DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="py-12">
        @if($permissions->add_permission == 1 || true)
        <a href="{{ route('users.create') }}"
            class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25"
            style="margin-left: 100px;">
            Create New User
        </a>
        @endif


        <div class="max-w-7xl mx-auto sm:px-3 lg:px-8" style="background-color: transparent; border: 3px solid wheat; border-radius: 20px;">
            <div class="bg-white shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">
                @if(Auth::user()->role_id == 1)
                <div class="flex justify-center">
                    <button class="tab-button active py-2 px-4 bg-blue-500 text-white border border-white rounded-lg relative" data-tab="active-users" style="margin-right: 15px;">
                        Active Users
                        <div class="absolute w-6 h-6 text-xs font-bold text-black bg-white border-2 border-white rounded-full top-0 right-0 transform translate-x-1/2 -translate-y-1/2 flex items-center justify-center" >
                            <span style="color: black;">{{ $activeUsers->count() }}</span>
                        </div>
                    </button>

                    <button class="tab-button py-2 px-4 bg-gray-300 text-gray-700 border border-white rounded-lg hover:bg-blue-200 relative" data-tab="inactive-users">
                        Inactive Users
                        <div class="absolute w-6 h-6 text-xs font-bold text-black bg-white border-2 border-white rounded-full top-0 right-0 transform translate-x-1/2 -translate-y-1/2 flex items-center justify-center" >
                            <span style="color: black;">{{ $deactiveUsers->count() }}</span>
                        </div>
                    </button>
                </div>


                <div class="tab-content-container mt-6">
                    <!-- Active Users -->
                    <div id="active-users" class="tab-content">
                        @if($activeUsers->count() > 0)
                        <div class="overflow-auto">
                            <table id="activeUsersTable" class="display nowrap w-full">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeUsers as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="max-width: 100px;">
                                            @if($user->profile_image)
                                            <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}'s profile"
                                                class="h-10 w-10 rounded-full object-cover border-2 border-blue-500">
                                            @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center border-2 border-blue-500">
                                                <!-- Default people icon (SVG) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-full w-full text-gray-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-3.866 0-7 3.134-7 7s3.134 7 7 7 7-3.134 7-7-3.134-7-7-7zm0 0c-1.104 0-2-.896-2-2s.896-2 2-2 2 .896 2 2-.896 2-2 2zM12 1c-6.627 0-12 5.373-12 12 0 6.627 5.373 12 12 12s12-5.373 12-12c0-6.627-5.373-12-12-12z"></path>
                                                </svg>
                                            </div>
                                            @endif
                                        </td>

                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->userrole)
                                            <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-green-500 rounded-full" style="border: 2px solid white">
                                                {{ $user->userrole->name }}
                                            </span>
                                            @else
                                            <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-red-500 rounded-full" style="border: 2px solid white">
                                                No Role Assigned
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-green-500 rounded-full" style="border: 2px solid white">
                                                Active
                                            </span>
                                        </td>
                                        <td class="flex space-x-2" style="margin-top:50px;">
                                            <!-- View -->
                                            @if($permissions->show_permission == 1 )
                                            <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700" title="View" style="font-size: medium;margin: 5px 5px">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endif

                                            <!-- Edit -->
                                            @if($permissions->edit_permission == 1 )
                                            <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit" style="font-size: medium;margin: 5px 5px;color: blue;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif

                                            <!-- Delete -->
                                            @if($permissions->delete_permission == 1 )
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline" style="font-size: medium;margin: 5px 5px;color: red;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-white">No active users found.</p>
                        @endif
                    </div>

                    <!-- Inactive Users -->
                    <div id="inactive-users" class="tab-content hidden">
                        @if($deactiveUsers->count() > 0)
                        <div class="overflow-auto">
                            <table id="inactiveUsersTable" class="display nowrap w-full" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deactiveUsers as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="max-width: 100px;">
                                            @if($user->profile_image)
                                            <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}'s profile"
                                                class="h-10 w-10 rounded-full object-cover border-2 border-blue-500">
                                            @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center border-2 border-blue-500">
                                                <!-- Default people icon (SVG) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-3.866 0-7 3.134-7 7s3.134 7 7 7 7-3.134 7-7-3.134-7-7-7zm0 0c-1.104 0-2-.896-2-2s.896-2 2-2 2 .896 2 2-.896 2-2 2zM12 1c-6.627 0-12 5.373-12 12 0 6.627 5.373 12 12 12s12-5.373 12-12c0-6.627-5.373-12-12-12z"></path>
                                                </svg>
                                            </div>
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->userrole)
                                            <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-green-500 rounded-full" style="border: 2px solid white">
                                                {{ $user->userrole->name }}
                                            </span>
                                            @else
                                            <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-red-500 rounded-full" style="border: 2px solid white">
                                                No Role Assigned
                                            </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="inline-block py-1 px-3 text-xs font-semibold text-white bg-red-500 rounded-full" style="border: 2px solid white">
                                                Inactive
                                            </span>
                                        </td>
                                        <td class="flex space-x-2" style="margin-top:50px;">
                                            <!-- View -->
                                            <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700" title="View" style="font-size: medium;margin: 5px 5px">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit" style="font-size: medium;margin: 5px 5px;color: blue;">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline" style="font-size: medium;margin: 5px 5px;color: red;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-white">No inactive users found.</p>
                        @endif
                    </div>
                </div>
                @elseif(Auth::user()->role_id == 3)
                <div class="flex justify-between items-center border-b border-gray-300 mb-4">

                    <div class="flex space-x-4">
                        <button type="button" onclick="showTab('profile')" id="btn-profile" class="tab-btn active-tab text-white">
                            Profile
                        </button>

                    </div>


                    <div class="flex space-x-2">
                        @if($permissions->edit_permission == 1 )
                        <button id="edit-button" type="button"
                            class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                            <a href="{{ route('users.edit', Auth::user()->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit" style="font-size: medium;margin: 5px 5px;color: blue;">
                                Edit
                            </a>
                        </button>
                        @endif
                        
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
                            <img src="{{ Storage::url(Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}'s profile"
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
                                "name": "{{ Auth::user()->name }}",
                                "description": "Payment for Service",
                                "image": "{{ Storage::url(Auth::user()->profile_image ?? '') }}", // Optional
                                "handler": function(response) {
                                    alert("Payment successful! Razorpay Payment ID: " + response.razorpay_payment_id);
                                    // TODO: Send the payment ID to your server via AJAX and update the database
                                },
                                "prefill": {
                                    "name": "{{ Auth::user()->name }}",
                                    "email": "{{ Auth::user()->email }}",
                                    "contact": "{{ Auth::user()->number }}"
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
                @endif


            </div>
        </div>

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
    {{-- jQuery + DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <!-- Dependencies for PDF and Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize the DataTable for active users (admin view)
            if ($('#activeUsersTable').length) {
                $('#activeUsersTable').DataTable({
                    responsive: true,
                    dom: 'lBfrtip', // Added 'l' for length/page size selection
                    pageLength: 10, // Default page length
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ], // Page length options
                    language: {
                        search: "", // Remove the "Search" text from the search input
                        searchPlaceholder: "Search...", // Add a placeholder instead
                        lengthMenu: "_MENU_", // Only show dropdown without text
                        info: "Showing _START_ to _END_ of _TOTAL_ entries" // Info text format
                    },
                    buttons: [{
                            extend: "copyHtml5",
                            text: '<i class="fas fa-copy"></i>',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel"></i>',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "csvHtml5",
                            text: '<i class="fas fa-file-csv"></i>',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            text: '<i class="fas fa-file-pdf"></i>',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "print",
                            text: '<i class="fas fa-print"></i>',
                            exportOptions: {
                                columns: ':visible'
                            }
                        }
                    ]
                });
            }

            // Initialize the DataTable for inactive users when the tab is clicked (admin view)
            $('.tab-button[data-tab="inactive-users"]').click(function() {
                if (!$.fn.DataTable.isDataTable('#inactiveUsersTable') && $('#inactiveUsersTable').length) {
                    $('#inactiveUsersTable').DataTable({
                        responsive: true,
                        dom: 'lBfrtip',
                        pageLength: 10,
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ], // Page length options
                        language: {
                            search: "", // Remove the "Search" text from the search input
                            searchPlaceholder: "Search...", // Add a placeholder instead
                            lengthMenu: "_MENU_", // Only show dropdown without text
                            info: "Showing _START_ to _END_ of _TOTAL_ entries" // Info text format
                        },
                        buttons: [{
                                extend: "copyHtml5",
                                text: '<i class="fas fa-copy"></i>',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: "excelHtml5",
                                text: '<i class="fas fa-file-excel"></i>',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: "csvHtml5",
                                text: '<i class="fas fa-file-csv"></i>',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: "pdfHtml5",
                                text: '<i class="fas fa-file-pdf"></i>',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: "print",
                                text: '<i class="fas fa-print"></i>',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            }
                        ]
                    });
                }
            });

            // Initialize the DataTable for user profile (role_id 3 view)
            if ($('#userProfileTable').length) {
                $('#userProfileTable').DataTable({
                    responsive: true,
                    dom: 'Bfrtip',
                    paging: false,
                    searching: false,
                    info: false,
                    buttons: [{
                            extend: "copyHtml5",
                            text: '<i class="fas fa-copy"></i>',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "print",
                            text: '<i class="fas fa-print"></i>',
                            exportOptions: {
                                columns: ':visible'
                            }
                        }
                    ]
                });
            }

            // Tab functionality (for admin view)
            $('.tab-button').click(function() {
                const tabId = $(this).data('tab');
                $('.tab-button').removeClass('active').addClass('bg-gray-300 text-gray-700');
                $(this).addClass('active').removeClass('bg-gray-300 text-gray-700');
                $('.tab-content').addClass('hidden');
                $('#' + tabId).removeClass('hidden');
            });
        });
    </script>
</x-app-layout>