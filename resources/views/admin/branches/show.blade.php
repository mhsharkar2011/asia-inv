@extends('layouts.app')

@section('title', 'Branch Details: ' . $branch->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">Branches</a></li>
    <li class="breadcrumb-item active">View {{ $branch->name }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-shadow">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Branch Details
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4 class="text-primary">{{ $branch->name }}</h4>
                            <span class="badge bg-secondary fs-6">{{ $branch->code }}</span>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge {{ $branch->is_active ? 'bg-success' : 'bg-danger' }} fs-6">
                                {{ $branch->is_active ? 'ACTIVE' : 'INACTIVE' }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-map-marker-alt"></i> Contact Information
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%"><i class="fas fa-map-marked-alt"></i> Address:</th>
                                    <td>{{ $branch->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-city"></i> City:</th>
                                    <td>{{ $branch->city ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-globe"></i> Country:</th>
                                    <td>{{ $branch->country ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-phone"></i> Phone:</th>
                                    <td>{{ $branch->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-envelope"></i> Email:</th>
                                    <td>
                                        @if($branch->email)
                                            <a href="mailto:{{ $branch->email }}">{{ $branch->email }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-user-tie"></i> Management
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%"><i class="fas fa-user"></i> Manager:</th>
                                    <td>{{ $branch->manager_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-calendar-alt"></i> Created:</th>
                                    <td>{{ $branch->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-edit"></i> Last Updated:</th>
                                    <td>{{ $branch->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-id-badge"></i> Status:</th>
                                    <td>
                                        @if($branch->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($branch->description)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-alt"></i> Description
                            </h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $branch->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('branches.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
