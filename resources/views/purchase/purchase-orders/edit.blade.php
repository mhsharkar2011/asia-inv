@extends('layouts.app')

@section('title', 'Edit Purchase Order')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square text-warning"></i>
                        Edit Purchase Order: {{ $purchaseOrder->po_number }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('purchase-orders.update', $purchaseOrder) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Basic Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="po_number" class="form-label">PO Number *</label>
                                            <input type="text" class="form-control @error('po_number') is-invalid @enderror"
                                                   id="po_number" name="po_number"
                                                   value="{{ old('po_number', $purchaseOrder->po_number) }}" required>
                                            @error('po_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="company_id" class="form-label">Company *</label>
                                            <select class="form-select @error('company_id') is-invalid @enderror"
                                                    id="company_id" name="company_id" required>
                                                <option value="">Select Company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ old('company_id', $purchaseOrder->company_id) == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="order_date" class="form-label">Order Date *</label>
                                                <input type="date" class="form-control @error('order_date') is-invalid @enderror"
                                                       id="order_date" name="order_date"
                                                       value="{{ old('order_date', $purchaseOrder->order_date->format('Y-m-d')) }}" required>
                                                @error('order_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="expected_delivery_date" class="form-label">Expected Delivery Date</label>
                                                <input type="date" class="form-control @error('expected_delivery_date') is-invalid @enderror"
                                                       id="expected_delivery_date" name="expected_delivery_date"
                                                       value="{{ old('expected_delivery_date', $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('Y-m-d') : '') }}">
                                                @error('expected_delivery_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Supplier & Warehouse -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <
