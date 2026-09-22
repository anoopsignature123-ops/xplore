@extends('admin.includes.layout')

@section('title', 'Activity Logs')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Activity Logs</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">Activity Logs</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- Filters Section -->
                    <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center rounded-top">
                        <h5 class="mb-0 text-primary">System Activity Logs</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection">
                                <i class="fas fa-filter"></i> Filters
                            </button> 
                            <button class="btn btn-danger btn-sm" type="button" id="btnClearLogs">
                                <i class="fas fa-trash-alt"></i> Clear Logs
                            </button>
                        </div>
                    </div>
                    
                    <div class="collapse mb-3" id="filterSection">
                        <div class="card border-0 shadow-sm mb-0">
                            <div class="card-body bg-light">
                                <div class="row g-3 align-items-end">
                                    <div class="col-12 col-md-3">
                                        <label class="form-label text-dark fw-semibold mb-1">Role</label>
                                        <select class="form-select select2" id="filter_role">
                                            <option value="">All Roles</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label text-dark fw-semibold mb-1">System User</label>
                                        <select class="form-select select2" id="filter_user">
                                            <option value="">All Users</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} | {{ $user->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label text-dark fw-semibold mb-1">From Date</label>
                                        <input type="text" class="form-control datePicker" id="from_date" placeholder="Select From Date">
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label text-dark fw-semibold mb-1">To Date</label>
                                        <input type="text" class="form-control datePicker" id="to_date" placeholder="Select To Date">
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <button type="button" class="btn btn-primary btn-sm w-100 mb-1" id="btnFilter"><i class="fas fa-search"></i> Apply</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" id="btnResetFilter"><i class="fas fa-redo-alt"></i> Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Target</th>
                                        <th>Date/Time</th>
                                        <th>Properties</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<!-- Properties Modal -->
<div class="modal fade" id="propertiesModal" tabindex="-1" aria-labelledby="propertiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="propertiesModalLabel">Activity Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="propertiesContent" style="background: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 400px; overflow-y: auto;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#basic-1').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.activity-logs.list') }}",
                data: function(d) {
                    d.role = $('#filter_role').val();
                    d.user_id = $('#filter_user').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'role', name: 'role'},
                {data: 'user', name: 'user'},
                {data: 'description', name: 'description'},
                {data: 'subject', name: 'subject'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[4, 'desc']]
        });

        // Filter Apply
        $('#btnFilter').on('click', function() {
            table.ajax.reload();
        });

        // Filter Reset
        $('#btnResetFilter').on('click', function() {
            $('#filter_role').val('').trigger('change');
            $('#filter_user').val('').trigger('change');
            $('#from_date').val('');
            $('#to_date').val('');
            table.ajax.reload();
        });

        // Auto-fill to_date when from_date changes
        $('#from_date').on('change', function() {
            var fromDate = $(this).val();
            if(fromDate && $('#to_date').val() === '') {
                $('#to_date').val(fromDate);
            }
        });

        // View Properties Modal
        $(document).on('click', '.view-properties', function() {
            var props = $(this).data('properties');
            // format json nicely
            var formatted = JSON.stringify(props, null, 4);
            $('#propertiesContent').text(formatted);
            $('#propertiesModal').modal('show');
        });

        // Clear Logs
        $('#btnClearLogs').on('click', function() {
            confirmDelete(function() {
                $.ajax({
                    url: "{{ route('admin.activity-logs.clear') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            showToast('success', response.message);
                            table.ajax.reload(null, false);
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: function() {
                        showToast('error', "Something went wrong!");
                    }
                });
            });
        });
    });
</script>
@endpush
