@extends('layouts.app')

@section('title', 'Reports - Coming Soon')

@section('content')
    <div class="container-fluid py-5">
        <div class="text-center">
            <i class="fas fa-chart-line fa-5x text-primary mb-4"></i>
            <h1 class="h3 mb-3">Reports Module</h1>
            <p class="text-muted mb-4">The reports module is currently under development.</p>
            <a href="{{ route('dashboard.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>
@endsection
