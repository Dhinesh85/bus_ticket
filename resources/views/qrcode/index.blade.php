<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Scan') }}
        </h2>
    </x-slot>

    <style>
        @media (max-width: 570px) {
            .overflow-auto {
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
        
        /* Badge styling */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
            border: 2px solid white;
        }
        
        .badge-success {
            background-color: #10b981;
            color: white;
        }
        
        .badge-warning {
            background-color: #f59e0b;
            color: white;
        }
        
        .badge-danger {
            background-color: #ef4444;
            color: white;
        }
        
        /* Action icons styling */
        .action-icon {
            font-size: medium;
            margin: 5px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        .action-icon:hover {
            transform: scale(1.2);
        }
        
        .icon-view {
            color: #3b82f6;
        }
        
        .icon-edit {
            color: #3b82f6;
        }
        
        .icon-delete {
            color: #ef4444;
        }
    </style>

    {{-- Include DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="py-12">
        @if($permissions->add_permission == 1)
        <a href="{{ route('qr-scan.create') }}"  class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25"
        style="margin-left: 100px;">            
               Scan
           
        </a>
        @endif

        <div class="max-w-7xl mx-auto sm:px-3 lg:px-8" style="background-color: transparent; border: 3px solid wheat; border-radius: 20px;">
            <div class="bg-white shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">
               

                <!-- Calls when session success triggers starts -->
                @if (session('success'))
                <div class="alert alert-success bg-green-100 border-t-4 border-green-500 rounded-b text-green-600 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm text-success">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                <!-- Calls when session success triggers ends -->
                
                <!-- Calls when validation errors triggers starts -->
                @if ($errors->any())
                <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                    <p><strong>Oops! Something went wrong</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- Calls when validation errors triggers ends -->
                
                <!-- Calls when session error triggers starts -->
                @if (session('error'))
                <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm text-danger">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                <!-- Calls when session error triggers ends -->

                <div class="tab-content-container mt-6">
                    <!-- Domestic Locations -->
                    <div id="active-locations" class="tab-content">
                        <div class="overflow-auto">
                            <table id="domesticLocationsTable" class="display nowrap w-full">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>City</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Payment</th>
                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locations as $location)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $location->city }}</td>
                                        <td>{{ $location->from }}</td>
                                        <td>{{ $location->to }}</td>
                                        <td>{{ $location->payment }}</td>
                                       
                                        <td class="flex space-x-2">
                                            <!-- View -->
                                            @if($permissions->show_permission == 1)
                                            <a href="{{ route('category.show', $location->id) }}" class="action-icon icon-view" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endif

                                            <!-- Edit -->
                                            <!-- @if($permissions->edit_permission == 1)
                                            <a href="{{ route('category.edit', $location->id) }}" class="action-icon icon-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif -->

                                            <!-- Delete -->
                                            @if($permissions->delete_permission == 1)
                                            <form action="{{ route('category.destroy', $location->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this location?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-icon icon-delete" title="Delete">
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
                    </div>
                    
                    <!-- International Locations -->
                  
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
            // Initialize the DataTable for domestic locations
            $('#domesticLocationsTable').DataTable({
                responsive: true,
                dom: 'lBfrtip', // Added 'l' for length/page size selection
                pageLength: 10, // Default page length
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ], // Page length options
                language: {
                    search: "", // Remove the "Search" text from the search input
                    searchPlaceholder: "Search locations...", // Add a placeholder instead
                    lengthMenu: "_MENU_", // Only show dropdown without text
                    info: "Showing _START_ to _END_ of _TOTAL_ entries" // Info text format
                },
                buttons: [{
                        extend: "copyHtml5",
                        text: '<i class="fas fa-copy"></i>',
                        titleAttr: 'Copy to clipboard',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: "excelHtml5",
                        text: '<i class="fas fa-file-excel"></i>',
                        titleAttr: 'Export to Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: "csvHtml5",
                        text: '<i class="fas fa-file-csv"></i>',
                        titleAttr: 'Export to CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fas fa-file-pdf"></i>',
                        titleAttr: 'Export to PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: "print",
                        text: '<i class="fas fa-print"></i>',
                        titleAttr: 'Print table',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                   
                ]
            });

            // Initialize the DataTable for international locations when the tab is clicked
           

            // Tab functionality
        
        });
    </script>
</x-app-layout>