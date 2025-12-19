@extends('layouts.app')

@section('title', $organization->name)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h4 fw-bold mb-1">{{ $organization->name }}</h2>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-{{ $organization->type }} me-2">
                                {{ ucfirst($organization->type) }}
                            </span>
                            <span class="text-muted">Code: {{ $organization->code }}</span>
                            @if ($organization->sub_type)
                                <span class="ms-2 badge bg-light text-dark">{{ $organization->sub_type }}</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.organizations.edit', $organization) }}" class="btn btn-warning me-2">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.organizations.index', ['type' => $organization->type]) }}"
                            class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>

                <!-- Organization Details -->
                <div class="row">
                    <!-- Left Column: Basic Info -->
                    <div class="col-lg-8">
                        <div class="row">
                            <!-- Contact Card -->
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0">
                                            <i class="bi bi-person-lines-fill me-2 text-primary"></i>Contact Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Contact Person</label>
                                            <strong>{{ $organization->contact_person ?? 'N/A' }}</strong>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Email</label>
                                            @if ($organization->email)
                                                <a href="mailto:{{ $organization->email }}" class="text-decoration-none">
                                                    <i class="bi bi-envelope me-1"></i>{{ $organization->email }}
                                                </a>
                                            @else
                                                <span>N/A</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Phone</label>
                                            @if ($organization->phone)
                                                <a href="tel:{{ $organization->phone }}" class="text-decoration-none">
                                                    <i class="bi bi-telephone me-1"></i>{{ $organization->phone }}
                                                </a>
                                            @else
                                                <span>N/A</span>
                                            @endif
                                        </div>
                                        @if ($organization->mobile)
                                            <div class="mb-3">
                                                <label class="text-muted d-block">Mobile</label>
                                                <a href="tel:{{ $organization->mobile }}" class="text-decoration-none">
                                                    <i class="bi bi-phone me-1"></i>{{ $organization->mobile }}
                                                </a>
                                            </div>
                                        @endif
                                        @if ($organization->website)
                                            <div>
                                                <label class="text-muted d-block">Website</label>
                                                <a href="{{ $organization->website }}" target="_blank"
                                                    class="text-decoration-none">
                                                    <i class="bi bi-globe me-1"></i>{{ $organization->website }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Address Card -->
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0">
                                            <i class="bi bi-geo-alt-fill me-2 text-success"></i>Address
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($organization->address)
                                            <div class="mb-3">
                                                <label class="text-muted d-block">Address</label>
                                                <strong>{{ $organization->address }}</strong>
                                            </div>
                                        @endif

                                        <div class="row">
                                            @if ($organization->city)
                                                <div class="col-6 mb-3">
                                                    <label class="text-muted d-block">City</label>
                                                    <strong>{{ $organization->city }}</strong>
                                                </div>
                                            @endif

                                            @if ($organization->district)
                                                <div class="col-6 mb-3">
                                                    <label class="text-muted d-block">District</label>
                                                    <strong>{{ $organization->district }}</strong>
                                                </div>
                                            @endif

                                            @if ($organization->country)
                                                <div class="col-6 mb-3">
                                                    <label class="text-muted d-block">Country</label>
                                                    <strong>{{ $organization->country }}</strong>
                                                </div>
                                            @endif

                                            @if ($organization->postal_code)
                                                <div class="col-6 mb-3">
                                                    <label class="text-muted d-block">Postal Code</label>
                                                    <strong>{{ $organization->postal_code }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                        @if ($organization->latitude && $organization->longitude)
                                            <div class="mt-3">
                                                <a href="https://maps.google.com/?q={{ $organization->latitude }},{{ $organization->longitude }}"
                                                    target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-map me-1"></i>View on Map
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Card -->
                            <div class="col-md-12 mb-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0">
                                            <i class="bi bi-cash-stack me-2 text-warning"></i>Financial Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Tax Information -->
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="text-muted d-block">TIN Number</label>
                                                    <strong>{{ $organization->tin ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="text-muted d-block">BIN Number</label>
                                                    <strong>{{ $organization->bin ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="text-muted d-block">Trade License</label>
                                                    <strong>{{ $organization->trade_license ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Type-specific financial info -->
                                        @if ($organization->type == 'customer')
                                            <div class="row mt-3 border-top pt-3">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="text-muted d-block">Credit Limit</label>
                                                        <h4 class="text-primary">
                                                            ৳{{ number_format($organization->credit_limit, 2) }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="text-muted d-block">Outstanding Balance</label>
                                                        <h4
                                                            class="{{ $organization->outstanding_balance > 0 ? 'text-danger' : 'text-success' }}">
                                                            ৳{{ number_format($organization->outstanding_balance, 2) }}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($organization->type == 'supplier' && $organization->payment_terms)
                                            <div class="row mt-3 border-top pt-3">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="text-muted d-block">Payment Terms</label>
                                                        <strong>{{ $organization->payment_terms }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Description Card -->
                            @if ($organization->description || $organization->notes)
                                <div class="col-md-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white border-0">
                                            <h5 class="mb-0">
                                                <i class="bi bi-card-text me-2 text-info"></i>Additional Information
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($organization->description)
                                                <div class="mb-4">
                                                    <label class="text-muted d-block mb-2">Description</label>
                                                    <p class="mb-0">{{ $organization->description }}</p>
                                                </div>
                                            @endif

                                            @if ($organization->notes)
                                                <div>
                                                    <label class="text-muted d-block mb-2">Notes</label>
                                                    <p class="mb-0">{{ $organization->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Stats & Actions -->
                    <div class="col-lg-4">
                        <!-- Status Card -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white border-0">
                                <h5 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>Status & Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="text-muted d-block">Status</label>
                                    @if ($organization->is_active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>Inactive
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted d-block">Created</label>
                                    <strong>{{ $organization->created_at->format('d M Y, h:i A') }}</strong>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted d-block">Last Updated</label>
                                    <strong>{{ $organization->updated_at->format('d M Y, h:i A') }}</strong>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted d-block">Currency</label>
                                    <strong>{{ $organization->currency }}</strong>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted d-block">Language</label>
                                    <strong>{{ $organization->language == 'en' ? 'English' : 'Bangla' }}</strong>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted d-block">Timezone</label>
                                    <strong>{{ $organization->timezone }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white border-0">
                                <h5 class="mb-0">
                                    <i class="bi bi-lightning me-2"></i>Quick Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    @if ($organization->is_active)
                                        <form action="{{ route('admin.organizations.toggle-status', $organization) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-warning w-100 text-start">
                                                <i class="bi bi-pause-circle me-2"></i>Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.organizations.toggle-status', $organization) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success w-100 text-start">
                                                <i class="bi bi-play-circle me-2"></i>Activate
                                            </button>
                                        </form>
                                    @endif

                                    <a href="#" class="btn btn-outline-primary w-100 text-start">
                                        <i class="bi bi-file-text me-2"></i>View Transactions
                                    </a>

                                    <a href="#" class="btn btn-outline-info w-100 text-start">
                                        <i class="bi bi-printer me-2"></i>Print Details
                                    </a>

                                    <button class="btn btn-outline-secondary w-100 text-start" data-bs-toggle="modal"
                                        data-bs-target="#sendEmailModal">
                                        <i class="bi bi-envelope me-2"></i>Send Email
                                    </button>

                                    <form action="{{ route('admin.organizations.destroy', $organization) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this organization?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100 text-start">
                                            <i class="bi bi-trash me-2"></i>Delete Organization
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Related Organizations -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="mb-0">
                                    <i class="bi bi-diagram-3 me-2"></i>Quick Stats
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6 mb-3">
                                        <div class="p-3 bg-light rounded">
                                            <h3 class="fw-bold mb-1">0</h3>
                                            <small class="text-muted">Transactions</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="p-3 bg-light rounded">
                                            <h3 class="fw-bold mb-1">৳0</h3>
                                            <small class="text-muted">Total Value</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded">
                                            <h3 class="fw-bold mb-1">0</h3>
                                            <small class="text-muted">Orders</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded">
                                            <h3 class="fw-bold mb-1">0</h3>
                                            <small class="text-muted">Invoices</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Email Modal -->
    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Email to {{ $organization->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" placeholder="Email subject">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="4" placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Email will be sent to: {{ $organization->email ?? 'No email address available' }}
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Send Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
