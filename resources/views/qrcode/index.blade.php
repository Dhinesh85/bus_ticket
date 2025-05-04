<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Locations') }}
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

        /* QR Scanner Modal Styles */
        #qrModal {
            transition: all 0.3s ease;
        }

        #qr-reader {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
        }

        #qr-result {
            min-height: 50px;
            border-radius: 6px;
            padding: 10px;
            margin-top: 15px;
        }

        .scan-result-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid #10b981;
        }

        .ticket-checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 12px;
            padding: 8px;
            border-radius: 6px;
            background-color: rgba(37, 99, 235, 0.1);
            border: 1px solid #2563eb;
        }
    </style>

    {{-- Include DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Tailwind CSS (CDN for demo) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Html5 QR Code -->
    <script src="https://unpkg.com/html5-qrcode"></script>


    <div class="py-12">

        <!-- Button to open modal -->
        <button id="openModal" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25"
            style="margin-left: 100px;">
            <i class="fas fa-qrcode mr-2"></i> Scan QR Code
        </button>

        <!-- Modal -->
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

                @if (session('error'))
                <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm text-danger">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif


                <div class="tab-content-container mt-6">

                    <div id="active-locations" class="tab-content">
                        <div class="overflow-auto">

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
            // Initialize DataTable if it exists
            if ($('#domesticLocationsTable').length) {
                $('#domesticLocationsTable').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    language: {
                        search: "",
                        searchPlaceholder: "Search locations...",
                        lengthMenu: "_MENU_",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries"
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
            }
            
            // QR Scanner Variables
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
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0
                };
                
                // Start scanner
                scanner.start(
                    { facingMode: "environment" },
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
        });
    </script>

</x-app-layout>