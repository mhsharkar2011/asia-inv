@extends('layouts.admin')

@section('title', 'Audit Logs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Audit Logs</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Model ID</th>
                                <th>Old Values</th>
                                <th>New Values</th>
                                <th>IP Address</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->user->name ?? 'N/A' }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->model_type }}</td>
                                <td>{{ $log->model_id }}</td>
                                <td>
                                    <pre class="mb-0">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                </td>
                                <td>
                                    <pre class="mb-0">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                </td>
                                <td>{{ $log->ip_address }}</td>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
