<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Scan') }}
        </h2>
    </x-slot>

    {{-- Custom Styles --}}
    <style>
        @media (max-width: 570px) {
            .overflow-auto {
                overflow-x: auto;
            }
        }

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

        .dt-button:hover {
            background-color: rgba(37, 99, 235, 0.2) !important;
        }

        table.dataTable thead th,
        table.dataTable tbody td,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate,
        .dataTables_wrapper .dataTables_length {
            color: white !important;
        }

        .dataTables_length select,
        .dataTables_filter input {
            background-color: transparent;
            color: white;
            border: 1px solid #2563eb;
            border-radius: 4px;
            padding: 4px 8px;
        }

        .dataTables_paginate .paginate_button {
            background-color: transparent !important;
            color: white !important;
            border: 1px solid #2563eb !important;
            border-radius: 4px;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #2563eb !important;
        }

        .tab-button.active {
            background-color: #2563eb;
            color: white;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
            border: 2px solid white;
        }

        .badge-success { background-color: #10b981; }
        .badge-warning { background-color: #f59e0b; }
        .badge-danger  { background-color: #ef4444; }

        .action-icon {
            font-size: medium;
            margin: 5px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .action-icon:hover {
            transform: scale(1.2);
        }

        .icon-view  { color: #3b82f6; }
        .icon-delete { color: #ef4444; }
    </style>

    {{-- Include CSS for DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Page Content --}}
    <div class="py-12">
        @if($permissions->add_permission == 1)
            <a href="{{ route('qr-scan.create') }}"
               class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold text-white uppercase bg-gray-800 rounded-md hover:bg-gray-700"
               style="margin-left: 100px;">
                Scan
            </a>
        @endif

        <div class="max-w-7xl mx-auto sm:px-3 lg:px-8"
             style="background-color: transparent; border: 3px solid wheat; border-radius: 20px;">
            <div class="shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="bg-green-100 border-t-4 border-green-500 text-green-600 px-4 py-3 rounded mb-4">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-600 px-4 py-3 rounded mb-4">
                        <strong>Oops! Something went wrong:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="bg-red-100 text-red-600 px-4 py-3 rounded mb-4">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="tab-content-container mt-6">
                    <div id="active-locations" class="tab-content">
                        <div class="overflow-auto">
                        <table id="domesticLocationsTable" class="display nowrap w-full">
    <thead>
        <tr>
            <th>#Id</th>
            <th>User</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>City</th>
            <th>From</th>
            <th>To</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($locations as $location)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $location->user->name ?? 'N/A' }}</td>
                <td>{{ $location->from }}</td>
                <td>{{ $location->to }}</td>
                <td>{{ $location->city }}</td>
                <td>{{ $location->from }}</td>
                <td>{{ $location->to }}</td>
                <td class="flex space-x-2">
                    {{-- View --}}
                    @if($permissions->show_permission == 1)
                        <a href="{{ route('category.show', $location->id) }}"
                           class="action-icon icon-view" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    @endif

                    {{-- Delete --}}
                    @if($permissions->delete_permission == 1)
                        <form action="{{ route('category.destroy', $location->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this location?')"
                              class="inline">
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
                </div>

            </div>
        </div>
    </div>

    {{-- Include JS for DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    {{-- DataTables Config --}}
    <script>
        $(document).ready(function () {
            $('#domesticLocationsTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy' },
                    { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV' },
                    { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Print' }
                ]
            });
        });
    </script>
</x-app-layout>
