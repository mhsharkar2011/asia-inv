@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Reports</h1>
                <p class="text-muted mb-0">Generate and view various business reports</p>
            </div>
        </div>

        <!-- Report Cards -->
        <div class="row">
            <!-- Sales Report Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Sales Report</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    Revenue & Sales Analysis
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('reports.sales') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Report Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Customer Report</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    Customer Analysis & Statistics
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('reports.customers') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-eye me-1"></i>View Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Report Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Product Report</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    Stock & Inventory Analysis
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-boxes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('reports.products') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye me-1"></i>View Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tax Report Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    GST/Tax Report</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    Tax Collection & Analysis
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('reports.tax') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-eye me-1"></i>View Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Reports -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Reports</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reports.sales') }}" method="GET" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ date('Y-m-01') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-t') }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-chart-bar me-2"></i>Generate Sales Report
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-left-primary mb-3">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Today's Summary</h6>
                                        <div class="mt-2">
                                            <a href="{{ route('reports.sales') }}?start_date={{ date('Y-m-d') }}&end_date={{ date('Y-m-d') }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-calendar-day me-1"></i>Today's Sales
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-left-success mb-3">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">This Month</h6>
                                        <div class="mt-2">
                                            <a href="{{ route('reports.sales') }}?start_date={{ date('Y-m-01') }}&end_date={{ date('Y-m-t') }}"
                                                class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-calendar-alt me-1"></i>Monthly Report
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Export Options</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Export reports in various formats:</p>

                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-success" disabled>
                                <i class="fas fa-file-excel me-2"></i>Export to Excel
                            </button>
                            <button class="btn btn-outline-danger" disabled>
                                <i class="fas fa-file-pdf me-2"></i>Export to PDF
                            </button>
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="fas fa-file-csv me-2"></i>Export to CSV
                            </button>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Export features require additional packages to be installed.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Report Modal -->
    <div class="modal fade" id="quickReportModal" tabindex="-1" aria-labelledby="quickReportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickReportModalLabel">Quick Report Generator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="quickReportForm">
                        <div class="mb-3">
                            <label class="form-label">Report Type</label>
                            <select class="form-select" name="report_type">
                                <option value="sales">Sales Report</option>
                                <option value="customers">Customer Report</option>
                                <option value="products">Product Report</option>
                                <option value="tax">Tax Report</option>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ date('Y-m-01') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-t') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Format</label>
                            <select class="form-select" name="format">
                                <option value="view">View in Browser</option>
                                <option value="pdf" disabled>PDF (Coming Soon)</option>
                                <option value="excel" disabled>Excel (Coming Soon)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="generateQuickReport()">
                        <i class="fas fa-play me-2"></i>Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function generateQuickReport() {
            const form = document.getElementById('quickReportForm');
            const formData = new FormData(form);
            const reportType = formData.get('report_type');
            const format = formData.get('format');
            const startDate = formData.get('start_date');
            const endDate = formData.get('end_date');

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('quickReportModal'));
            modal.hide();

            // Redirect based on report type
            let url = '';
            switch (reportType) {
                case 'sales':
                    url = '{{ route('reports.sales') }}';
                    break;
                case 'customers':
                    url = '{{ route('reports.customers') }}';
                    break;
                case 'products':
                    url = '{{ route('reports.products') }}';
                    break;
                case 'tax':
                    url = '{{ route('reports.tax') }}';
                    break;
            }

            // Add query parameters
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            // Redirect to report
            window.location.href = url;
        }
    </script>
@endpush
