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
        @if($permissions->add_permission == 1 )
        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25" style="color: white;">
            <button class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25" style="margin-left: 100px;">
                Create New User</button>
        </a>
        @endif
      
        <div class="max-w-7xl mx-auto sm:px-3 lg:px-8" style="background-color: transparent; border: 3px solid wheat; border-radius: 20px;">
            <div class="bg-white shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">
           
                <div class="flex justify-center">
                    <button class="tab-button active py-2 px-4 bg-blue-500 text-white border border-white rounded-lg relative" data-tab="active-users" style="margin-right: 15px;">
                        Active Users
                        <div class="absolute w-6 h-6 text-xs font-bold text-black bg-white border-2 border-white rounded-full top-0 right-0 transform translate-x-1/2 -translate-y-1/2 flex items-center justify-center" style="top: -15px;right: -10px;">
                            <span style="color: black;">{{ $activeUsers->count() }}</span>
                        </div>
                    </button>

                    <button class="tab-button py-2 px-4 bg-gray-300 text-gray-700 border border-white rounded-lg hover:bg-blue-200 relative" data-tab="inactive-users">
                        Inactive Users
                        <div class="absolute w-6 h-6 text-xs font-bold text-black bg-white border-2 border-white rounded-full top-0 right-0 transform translate-x-1/2 -translate-y-1/2 flex items-center justify-center" style="top: -15px;right: -10px;">
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



               

            </div>
        </div>
    </div>
    

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