            <!-- Page Content -->
                <!-- Hero -->
                <div class="bg-body-light">
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                            <div class="flex-grow-1">
                                <h1 class="h3 fw-bold mb-1">
                                    Orders Manager
                                </h1>
                                <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                                    That feeling of money when you start using your orders.
                                </h2>
                            </div>
                            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-alt">
                                    <li class="breadcrumb-item">
                                        <a class="link-fx" href="https://waxa.pw/main">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        MyOrders
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- END Hero -->
 
                <div class="content">
                    <!-- Quick Overview -->
                    <div class="row g-3 mb-4 mt-3">
                        <div class="col-6 col-lg-3">
                            <div class="block block-rounded block-link-pop bg-body-extra-light h-100 mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Orders">
                                <div class="block-content block-content-full p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fs-sm fw-semibold text-uppercase text-muted mb-2">
                                                <i class="fas fa-shopping-cart me-1 animate-slide"></i> All Orders
                                            </div>
                                            <div class="fs-2 fw-bold text-primary">
                                                <span class="count-up">0</span>
                                            </div>
                                        </div>
                                        <i class="fas fa-chart-line fa-2x text-primary opacity-25 animate-float"></i>
                                    </div>
                                </div>
                                <div class="block-content py-2 bg-body-light">
                                    <p class="fw-medium fs-sm text-primary mb-0">
                                        <i class="fas fa-arrow-up me-1"></i> Total Orders
                                    </p>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-6 col-lg-3">
                            <div class="block block-rounded block-link-pop bg-body-extra-light h-100 mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Completed Orders">
                                <div class="block-content block-content-full p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fs-sm fw-semibold text-uppercase text-muted mb-2">
                                                <i class="fas fa-check-circle me-1 animate-bounce"></i> Completed
                                            </div>
                                            <div class="fs-2 fw-bold text-success">
                                                <span class="count-up">0</span>
                                            </div>
                                        </div>
                                        <i class="fas fa-clipboard-check fa-2x text-success opacity-25 animate-float"></i>
                                    </div>
                                </div>
                                <div class="block-content py-2 bg-body-light">
                                    <p class="fw-medium fs-sm text-success mb-0">
                                        <i class="fas fa-arrow-up me-1"></i> Successful Orders
                                    </p>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-6 col-lg-3">
                            <div class="block block-rounded block-link-pop bg-body-extra-light h-100 mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Reported Orders">
                                <div class="block-content block-content-full p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fs-sm fw-semibold text-uppercase text-muted mb-2">
                                                <i class="fas fa-exclamation-triangle me-1 animate-pulse"></i> Reported
                                            </div>
                                            <div class="fs-2 fw-bold text-danger">
                                                <span class="count-up">0</span>
                                            </div>
                                        </div>
                                        <i class="fas fa-bug fa-2x text-danger opacity-25 animate-float"></i>
                                    </div>
                                </div>
                                <div class="block-content py-2 bg-body-light">
                                    <p class="fw-medium fs-sm text-danger mb-0">
                                        <i class="fas fa-arrow-up me-1"></i> Orders Reported
                                    </p>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-6 col-lg-3">
                            <div class="block block-rounded block-link-pop bg-body-extra-light h-100 mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Rejected Reports">
                                <div class="block-content block-content-full p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fs-sm fw-semibold text-uppercase text-muted mb-2">
                                                <i class="fa fa-thumbs-up me-1 animate-bounce"></i> Refunded
                                            </div>
                                            <div class="fs-2 fw-bold text-warning">
                                                <span class="count-up">0</span>
                                            </div>
                                        </div>
                                        <i class="fa fa-diagram-successor fa-2x text-warning opacity-25 animate-float"></i>
                                    </div>
                                </div>
                                <div class="block-content py-2 bg-body-light">
                                    <p class="fw-medium fs-sm text-warning mb-0">
                                        <i class="fas fa-arrow-up me-1"></i> Refunded Orders
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
 
                    <style>
                        @keyframes float {
 
                            0%,
                            100% {
                                transform: translateY(0);
                            }
 
                            50% {
                                transform: translateY(-8px);
                            }
                        }
 
                        @keyframes slide {
 
                            0%,
                            100% {
                                transform: translateX(0);
                            }
 
                            50% {
                                transform: translateX(5px);
                            }
                        }
 
                        @keyframes bounce {
 
                            0%,
                            100% {
                                transform: translateY(0);
                            }
 
                            50% {
                                transform: translateY(-5px);
                            }
                        }
 
                        @keyframes pulse {
 
                            0%,
                            100% {
                                transform: scale(1);
                            }
 
                            50% {
                                transform: scale(1.2);
                            }
                        }
 
                        @keyframes spin {
                            0% {
                                transform: rotate(0deg);
                            }
 
                            100% {
                                transform: rotate(360deg);
                            }
                        }
 
                        @keyframes tilt {
                            0% {
                                transform: perspective(1000px) rotateX(0deg) rotateY(0deg);
                            }
 
                            100% {
                                transform: perspective(1000px) rotateX(2deg) rotateY(2deg);
                            }
                        }
 
                        /* Animation Classes */
                        .animate-float {
                            animation: float 3s ease-in-out infinite;
                        }
 
                        .animate-slide {
                            animation: slide 2s ease-in-out infinite;
                        }
 
                        .animate-bounce {
                            animation: bounce 1.5s ease-in-out infinite;
                        }
 
                        .animate-pulse {
                            animation: pulse 1.5s infinite linear;
                        }
 
                        .animate-spin {
                            animation: spin 2s linear infinite;
                        }
 
                        /* Block Styles */
                        .block-link-pop {
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                            transform-style: preserve-3d;
                            position: relative;
                            overflow: hidden;
                            border: 1px solid rgba(0, 0, 0, 0.075);
                            cursor: pointer;
                        }
 
                        .block-link-pop:hover {
                            transform: perspective(1000px) rotateX(2deg) rotateY(2deg) scale(1.02);
                            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
                        }
 
                        .block-link-pop::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            background: linear-gradient(45deg,
                                    rgba(255, 255, 255, 0.1) 0%,
                                    rgba(255, 255, 255, 0.2) 50%,
                                    rgba(255, 255, 255, 0.1) 100%);
                            opacity: 0;
                            transition: opacity 0.3s ease;
                            pointer-events: none;
                        }
 
                        .block-link-pop:hover::before {
                            opacity: 1;
                        }
 
                        /* General Styles */
                        .bg-body-extra-light {
                            background-color: rgba(248, 249, 250, 0.8);
                            backdrop-filter: blur(10px);
                        }
 
                        .count-up {
                            display: inline-block;
                            font-variant-numeric: tabular-nums;
                            min-width: 60px;
                        }
 
                        .row.mb-4 {
                            margin-bottom: 1.5rem !important;
                        }
 
                        .row.mt-3 {
                            margin-top: 1rem !important;
                        }
 
                        .mb-2 {
                            margin-bottom: 0.5rem !important;
                        }
                    </style>
                    <!-- END Quick Overview -->
 
 
 
                    <!-- All Products -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">All Orders</h3>
                            <div class="block-options">
                                <div class="dropdown">
                                    <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Filters <i class="fa fa-angle-down ms-1"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
                                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            Active Tickets
                                            <span class="badge bg-success rounded-pill">260</span>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            Pending Tickets
                                            <span class="badge bg-danger rounded-pill">24</span>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            Closed Tickets
                                            <span class="badge bg-primary rounded-pill">14503</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
 
                            <!-- All Products Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="userorders-table">
                                    <thead>
                                        <tr>
                                            <th title="Id">Id</th>
                                            <th title="Type">Type</th>
                                            <th title="Price">Price</th>
                                            <th title="Website">Website</th>
                                            <th title="Login">Login</th>
                                            <th title="Pass">Pass</th>
                                            <th title="Country">Country</th>
                                            <th title="Status" width="10">Status</th>
                                            <th title="Purshased">Purshased</th>
                                            <th title="Creation Date">Creation Date</th>
                                            <th title="Updated At">Updated At</th>
                                            <th title="View" width="10%">View</th>
                                            <th title="Report" width="15%">Report</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- END All Products Table -->
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
        </main>
        <!-- Footer -->
        <footer id="page-footer" class="bg-body-extra-light">
            <div class="content py-3">
                <div class="row fs-sm">
                    <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                        Page Loaded in 0.619 Seconds
                    </div>
                    <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                        <a class="fw-semibold" href="https://waxa.pw/main" target="_blank">WaXa V1.0</a> © <span data-toggle="year-copy"></span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END Footer -->
    </div>
 
    <!-- Include jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Then include Bootstrap Notify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js"></script>
 
    <!-- OneUI JS -->
    <script src="https://waxa.pw/assets/js/oneui.app.min.js"></script>
    <!-- Page JS Plugins -->
    <script src="https://waxa.pw/assets/js/plugins/chart.js/chart.umd.js"></script>
    <script src="https://waxa.pw/assets/js/lib/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-buttons/buttons.print.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/flatpickr/flatpickr.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/select2/js/select2.full.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="https://waxa.pw/assets/js/pages/be_pages_dashboard_v1.min.js"></script>
    <script src="https://waxa.pw/assets/js/plugins/slick-carousel/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        One.helpersOnLoad(['js-flatpickr', 'jq-datepicker', 'jq-maxlength', 'jq-select2', 'jq-masked-inputs', 'jq-rangeslider', 'jq-slick']);
    </script>
    <script type="module">
        $(function() {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["userorders-table"] = $("#userorders-table").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "https:\/\/waxa.pw\/orders",
                    "type": "GET",
                    "data": function(data) {
                        for (var i = 0, len = data.columns.length; i < len; i++) {
                            if (!data.columns[i].search.value) delete data.columns[i].search;
                            if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                            if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                            if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                        }
                        delete data.search.regex;
                    }
                },
                "columns": [{
                    "data": "id",
                    "name": "id",
                    "title": "Id",
                    "orderable": true,
                    "searchable": true,
                    "className": "text-center"
                }, {
                    "data": "type",
                    "name": "type",
                    "title": "Type",
                    "orderable": true,
                    "searchable": true,
                    "className": "text-center"
                }, {
                    "data": "price",
                    "name": "price",
                    "title": "Price",
                    "orderable": true,
                    "searchable": true,
                    "className": "text-center"
                }, {
                    "data": "url",
                    "name": "url",
                    "title": "Website",
                    "orderable": true,
                    "searchable": true,
                    "className": "text-center"
                }, {
                    "data": "login",
                    "name": "login",
                    "title": "Login",
                    "orderable": true,
                    "searchable": true,
                    "visible": false
                }, {
                    "data": "pass",
                    "name": "pass",
                    "title": "Pass",
                    "orderable": true,
                    "searchable": true,
                    "visible": false
                }, {
                    "data": "country",
                    "name": "country",
                    "title": "Country",
                    "orderable": true,
                    "searchable": true,
                    "visible": false
                }, {
                    "data": "report_status",
                    "name": "report_status",
                    "title": "Status",
                    "orderable": true,
                    "searchable": true,
                    "width": 10,
                    "className": "text-center"
                }, {
                    "data": "created_at",
                    "name": "created_at",
                    "title": "Purshased",
                    "orderable": true,
                    "searchable": true,
                    "className": "text-center"
                }, {
                    "data": "creation_date",
                    "name": "creation_date",
                    "title": "Creation Date",
                    "orderable": true,
                    "searchable": true,
                    "visible": false
                }, {
                    "data": "updated_at",
                    "name": "updated_at",
                    "title": "Updated At",
                    "orderable": true,
                    "searchable": true,
                    "visible": false
                }, {
                    "data": "view",
                    "name": "view",
                    "title": "View",
                    "orderable": false,
                    "searchable": false,
                    "width": "10%",
                    "className": "text-center"
                }, {
                    "data": "report",
                    "name": "report",
                    "title": "Report",
                    "orderable": false,
                    "searchable": false,
                    "width": "15%",
                    "className": "text-center"
                }],
                "dom": "Bfrtip",
                "order": [0, "desc"],
                "select": {
                    "style": "single"
                },
                "responsive": true,
                "autoWidth": false,
                "autoHeight": false,
                "buttons": [{
                    "extend": "excel"
                }, {
                    "extend": "csv"
                }, {
                    "text": "Text",
                    "action": function(e, dt, button, config) {
                        // Define the columns you want to export
                        const columnsToExport = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]; // Replace with indices of columns you want to export (e.g., ID, Name, Price)
 
                        // Fetch the data for the specified columns
                        var data = dt.buttons.exportData({
                            columns: columnsToExport // You can use an array of indices for the columns to export
                        });
 
                        var txt = "";
 
                        // Add headers for selected columns
                        txt += data.header.join("\t") + "\n";
 
                        // Add the data rows for the selected columns
                        data.body.forEach(function(row) {
                            let rowData = columnsToExport.map(colIndex => row[colIndex]);
                            txt += rowData.join("\t") + "\n"; // Join only the selected columns
                        });
 
                        // Create a Blob with the txt data and initiate the download
                        var blob = new Blob([txt], {
                            type: "text/plain;charset=utf-8;"
                        });
                        var link = document.createElement("a");
                        if (link.download !== undefined) {
                            var url = URL.createObjectURL(blob);
                            link.setAttribute("href", url);
                            link.setAttribute("download", "data.txt");
                            link.style.visibility = "hidden";
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }
                }]
            });
        });
    </script>
 
    <script>
        function viewOrder(element, event) {
            event.preventDefault();
 
            // Destructure dataset for cleaner access
            const {
                id: orderId,
                type: orderType,
                price: orderPrice,
                country: orderCountry,
                itemInfo: orderItemInfo,
                url: orderUrl,
                login: orderLogin,
                pass: orderPass,
                sellerId: orderSellerId
            } = element.dataset;
 
            const isDarkMode = document.body.classList.contains('dark-mode');
 
            // Process URL for cPanel orders
            const processUrl = (url) => {
                if (orderType.toLowerCase() !== 'cpanel') return url;
 
                try {
                    const urlObj = new URL(url);
                    urlObj.port = urlObj.protocol === 'https:' ? '2083' : '2082';
                    return urlObj.toString();
                } catch (e) {
                    console.error('Invalid URL format:', url);
                    return url;
                }
            };
 
            const processedUrl = orderUrl ? processUrl(orderUrl) : null;
 
            // Field configuration with sanitization
            const fields = [{
                    condition: orderId,
                    label: 'ID',
                    value: escapeHtml(orderId),
                    copyable: false
                },
                {
                    condition: orderType,
                    label: 'Type',
                    value: escapeHtml(orderType),
                    copyable: false
                },
                {
                    condition: orderPrice,
                    label: 'Price',
                    value: `$${escapeHtml(orderPrice)}`,
                    copyable: false
                },
                {
                    condition: orderCountry,
                    label: 'Country',
                    value: escapeHtml(orderCountry),
                    copyable: false
                },
                {
                    condition: orderItemInfo,
                    label: 'Information',
                    value: escapeHtml(orderItemInfo),
                    copyable: true
                },
                {
                    condition: processedUrl,
                    label: 'URL',
                    value: escapeHtml(processedUrl),
                    copyable: true
                },
                {
                    condition: orderLogin,
                    label: 'Login',
                    value: escapeHtml(orderLogin),
                    copyable: true
                },
                {
                    condition: orderPass,
                    label: 'Pass',
                    value: escapeHtml(orderPass),
                    copyable: true
                },
                {
                    condition: orderSellerId,
                    label: 'Seller',
                    value: `Seller${escapeHtml(orderSellerId)}`,
                    copyable: false
                }
            ];
 
            // Generate table rows dynamically
            const rows = fields.map(({
                    condition,
                    label,
                    value,
                    copyable
                }) =>
                condition ? `
            <tr>
                <td style="text-align: left;"><strong>${label}:</strong></td>
                <td>
                    ${value}
                    ${copyable ? `<button class="btn btn-sm btn-info copy-btn" data-content="${value}">
                        <i class="fa fa-copy"></i>
                    </button>` : ''}
                </td>
            </tr>` : ''
            ).join('');
 
            const htmlContent = `
        <div style="overflow-x:auto;">
            <table class="table table-striped table-vcenter table-hover" style="width: 100%;">
                <tbody>
                    <tr>
                        <td colspan="2"><strong>Thank you for shopping at WaXa!</strong></td>
                    </tr>
                    ${rows}
                    <tr id="copy-status" style="height: 30px;">
                        <td colspan="2" style="padding: 0 10px; text-align: center;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 10px; text-align: center; color: #dc3545;">
                            If you experience any issues with your item, you may request a replacement or refund within 12Hours of purchase date.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>`;
 
            // Configure modal options
            const modalOptions = {
                title: 'Order Details',
                html: htmlContent,
                icon: 'success',
                showCloseButton: true,
                confirmButtonText: 'Close',
                width: '650px',
                allowOutsideClick: false,
                customClass: {
                    popup: isDarkMode ? 'swal-dark-mode' : ''
                },
                didOpen: () => {
                    document.querySelectorAll('.copy-btn').forEach(button => {
                        button.addEventListener('click', handleCopyClick);
                    });
                },
                willClose: () => {
                    document.querySelectorAll('.copy-btn').forEach(button => {
                        button.removeEventListener('click', handleCopyClick);
                    });
                }
            };
 
            Swal.fire(modalOptions);
        }
 
        // Centralized copy handler with inline toast
        async function handleCopyClick() {
            const content = this.dataset.content;
            const statusRow = this.closest('.swal2-popup').querySelector('#copy-status td');
 
            try {
                await navigator.clipboard.writeText(content);
                statusRow.innerHTML = '<span style="color: #28a745;">✓ Copied to clipboard!</span>';
                setTimeout(() => {
                    statusRow.innerHTML = '';
                }, 2000);
            } catch (err) {
                console.error('Copy failed:', err);
                statusRow.innerHTML = '<span style="color: #dc3545;">✗ Copy failed!</span>';
                setTimeout(() => {
                    statusRow.innerHTML = '';
                }, 2000);
            }
        }
 
        // XSS protection
        function escapeHtml(unsafe) {
            return unsafe?.replace(/[&<>"']/g, match => ({
                '&': '&',
                '<': '<',
                '>': '>',
                '"': '"',
                "'": '''
            } [match])) || '';
        }
    </script>
 
 
    <script>
        function confirmRefund(orderId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to report this order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, report it!',
                cancelButtonText: 'No, cancel!',
                customClass: {
                    confirmButton: 'btn btn-danger m-1',
                    cancelButton: 'btn btn-secondary m-1'
                },
                buttonsStyling: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`refund-form-${orderId}`).submit();
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(tooltipTriggerEl => {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    boundary: 'window',
                    trigger: 'hover'
                });
            });
 
            document.querySelectorAll('.block-link-pop').forEach(block => {
                block.addEventListener('mousemove', (e) => {
                    const rect = block.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = block.offsetWidth / 2;
                    const centerY = block.offsetHeight / 2;
 
                    const rotateX = (centerY - y) / 15;
                    const rotateY = (x - centerX) / 15;
 
                    block.style.transform = `
                  perspective(1000px)
                  rotateX(${rotateX}deg)
                  rotateY(${rotateY}deg)
                  scale(1.02)
              `;
                });
 
                block.addEventListener('mouseleave', () => {
                    block.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
                });
            });
 
            const counters = document.querySelectorAll('.count-up');
 
            const animateCounter = (element, start, end, duration) => {
                let startTime = null;
                const easeOutQuad = (t) => t * (2 - t);
 
                const updateCounter = (timestamp) => {
                    if (!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / duration, 1);
                    const current = Math.floor(easeOutQuad(progress) * (end - start) + start);
                    element.textContent = current.toLocaleString();
 
                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    }
                };
 
                requestAnimationFrame(updateCounter);
            };
 
            counters.forEach(counter => {
                const target = parseInt(counter.textContent.replace(/,/g, ''), 10);
                counter.textContent = '0';
                animateCounter(counter, 0, target, 1500);
            });
        });
    </script>
</body>