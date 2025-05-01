<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - Role') }}
        </h2>
    </x-slot>

    {{-- ✅ Styles --}}
    <style>
        @media (max-width: 570px) {

            #active-users .overflow-auto,
            #inactive-users .overflow-auto {
                overflow-x: auto;
            }
        }

        .dt-button {
            background-color: transparent !important;
            color: white !important;
            border: 2px solid #2563eb;
            border-radius: 6px;
            margin: 2px 7px -4px 7px;
            padding: 5px 10px;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .dt-button:hover {
            background-color: rgba(37, 99, 235, 0.2) !important;
        }

        .dataTables_wrapper,
        .dataTables_filter input,
        .dataTables_length select,
        .dataTables_paginate .paginate_button {
            color: white !important;
            background-color: transparent !important;
        }

        .dataTables_filter label,
        .dataTables_length label {
            font-size: 0;
        }

        .dataTables_filter input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        table.dataTable thead th,
        table.dataTable tbody td {
            color: white !important;
        }

        #activeUsersTable,
        #activeUsersTable th,
        #activeUsersTable td {
            border: none !important;
        }

        #activeUsersTable th,
        #activeUsersTable td {
            padding: 10px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            accent-color: #2563eb;
            cursor: pointer;
        }
    </style>

    {{-- ✅ External Styles --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- ✅ Content --}}
    <div class="py-12">
        <a href="{{ route('roles.index') }}"
            class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 rounded-md hover:bg-green-500"
            style="margin-left: 100px;">
            Go Back
        </a>

        <div class="max-w-7xl mx-auto sm:px-3 lg:px-8" style="background-color: transparent; border: 3px solid wheat; border-radius: 20px;">
            <div class="shadow-xl sm:rounded-lg px-4 py-4" style="background-color: transparent;">

                {{-- ✅ Validation Errors --}}
                @if ($errors->any())
                <div class="alert alert-danger text-red-600 px-4 py-3 my-3 shadow-md">
                    <strong>Oops! Something went wrong:</strong>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- ✅ Session Error --}}
                @if (session('error'))
                <div class="alert alert-danger text-red-600 px-4 py-3 shadow-md my-3">
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
                @endif

                {{-- ✅ Form --}}
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-white">Name <span class="text-red-600">*</span></label>
                        <input type="text"
                            name="name"
                            placeholder="Enter Role name"
                            value="{{ old('name') }}"
                            required
                            class="w-full px-3 py-2 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            style="background-color: transparent; border: 2px solid white; border-radius: 11px; color: white;">
                        @error('name')
                        <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-white">Permissions <span class="text-red-600">*</span></label><br>

                        <div class="overflow-auto">
                            <table id="activeUsersTable" class="display nowrap w-full">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Permission</th>
                                        <th>Menu Assign</th>
                                        <th>Add Assign</th>
                                        <th>Edit Assign</th>
                                        <th>Delete Assign</th>
                                        <th>View Assign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $index => $permission)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <input type="checkbox" class="menu-assign" data-index="{{ $index }}"
                                                name="permission_id[]" value="{{ $permission->id }}">
                                        </td>
                                        <td>
                                <input type="checkbox" name="add_permission[]" class="assign-option assign-add-{{ $index }}"
                                    value="{{ $permission->id }}" style="display: none;">
                            </td>
                            <td>
                                <input type="checkbox" name="edit_permission[]" class="assign-option assign-edit-{{ $index }}"
                                    value="{{ $permission->id }}" style="display: none;">
                            </td>
                            <td>
                                <input type="checkbox" name="delete_permission[]" class="assign-option assign-delete-{{ $index }}"
                                    value="{{ $permission->id }}" style="display: none;">
                            </td>
                            <td>
                                <input type="checkbox" name="show_permission[]" class="assign-option assign-view-{{ $index }}"
                                    value="{{ $permission->id }}" style="display: none;">
                            </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 rounded-md hover:bg-gray-700">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- ✅ Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".menu-assign").forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const index = this.dataset.index;
                const visible = this.checked;
                ['add', 'edit', 'delete', 'view'].forEach(function (action) {
                    const element = document.querySelector(`.assign-${action}-${index}`);
                    if (element) {
                        element.style.display = visible ? 'inline-block' : 'none';
                        if (!visible) {
                            element.checked = false; // uncheck if hidden
                        }
                    }
                });
            });
        });
    });
</script>


    <script>
        $(document).ready(function() {
            $('#activeUsersTable').DataTable({
                responsive: true,
                dom: 'lBfrtip',
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "_MENU_",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries"
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
        });
    </script>
</x-app-layout>