@extends('admin.layouts.app')
@section('title', 'Driver Details')
@section('content')

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 ">
        <div>
            <h3 class="fw-bold mb-3 d-none">Home Page</h3>
        </div>
        <div class="ms-md-auto d-none py-2 py-md-0">
            <a href="{{ route('admin.driver.create') }}" class="btn btn-primary">Add Partner</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-user-check"></i> Personal Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <td>
                                        <img @if ($driver->userDetails && $driver->userDetails->profile_picture) src="{{ $driver->userDetails->profile_picture }}"
                                        @else src="{{ asset('admin/img/no-img.png') }}" @endif
                                            alt="Profile Image" width="250" height="350">
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <th class="fs-3">{{ ucfirst($driver->name) }}</th>
                                </tr>
                                <tr class="text-center">
                                    <td class="fs-3"><i class="fas fa-envelope"></i> : {{ $driver->email }}, <i
                                            class="fas fa-mobile-alt"></i> : {{ $driver->phone }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="fs-4">Registration Date:
                                        {{ \Carbon\Carbon::parse($driver->created_at)->format('d-m-Y h:i A') }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-home"></i> Address Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>City</th>
                                    <td>
                                        {{ ucfirst($driver->userDetails->city ?? 'N/A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ ucfirst($driver->userDetails->state ?? 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ ucfirst($driver->userDetails->country ?? 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>Postal Code</th>
                                    <td>{{ $driver->userDetails->postal_code ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ ucfirst($driver->userDetails->address ?? 'N/A') }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-university"></i> Account Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <td>{{ ucfirst($driver->userDetails->bank_name ?? 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>Account Holder</th>
                                    <td>
                                        {{ ucfirst($driver->userDetails->bank_account_holder ?? 'N/A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Account Number</th>
                                    <td>{{ $driver->userDetails->bank_account_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>IFSC Code</th>
                                    <td>{{ $driver->userDetails->bank_account_ifsc ?? 'N/A' }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-clipboard-list"></i> Documents</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Driving License</th>
                                    <td>
                                        @if ($driver->userDetails->driver_license)
                                            @php
                                                $dlStatus = $driver->userDetails->is_dl_verified;
                                                if ($dlStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($dlStatus == 'rejected') {
                                                    $status = 'Rejected';
                                                    $clr = 'danger';
                                                    $cls = 'd-none';
                                                } else {
                                                    $status = 'Approved';
                                                    $clr = 'success';
                                                    $cls = 'd-none';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $clr }}">{{ $status }}</span>
                                            <a href="javascript:;" class="btn btn-xs btn-primary"
                                                onclick="documentView('Driving License','{{ $driver->userDetails->driver_license }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'dl' ,'{{ route('admin.driver.update', $driver->userDetails->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'dl' ,'{{ route('admin.driver.update', $driver->userDetails->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Aadhar Card</th>
                                    <td>
                                        @if ($driver->userDetails->adhhar_card)
                                            @php
                                                $adhharStatus = $driver->userDetails->is_adhhar_verified;
                                                if ($adhharStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($adhharStatus == 'rejected') {
                                                    $status = 'Rejected';
                                                    $clr = 'danger';
                                                    $cls = 'd-none';
                                                } else {
                                                    $status = 'Approved';
                                                    $clr = 'success';
                                                    $cls = 'd-none';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $clr }}">{{ $status }}</span>
                                            <a href="javascript:;" class="btn btn-xs btn-primary"
                                                onclick="documentView('Aadhar Card','{{ $driver->userDetails->adhhar_card }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'adhhar' ,'{{ route('admin.driver.update', $driver->userDetails->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'adhhar' ,'{{ route('admin.driver.update', $driver->userDetails->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pan Card</th>
                                    <td>
                                        @if ($driver->userDetails->pan_card)
                                            @php
                                                $panStatus = $driver->userDetails->is_pan_verified;
                                                if ($panStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($panStatus == 'rejected') {
                                                    $status = 'Rejected';
                                                    $clr = 'danger';
                                                    $cls = 'd-none';
                                                } else {
                                                    $status = 'Approved';
                                                    $clr = 'success';
                                                    $cls = 'd-none';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $clr }}">{{ $status }}</span>
                                            <a href="javascript:;" class="btn btn-xs btn-primary"
                                                onclick="documentView('Pan Card','{{ $driver->userDetails->pan_card }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'pan' ,'{{ route('admin.driver.update', $driver->userDetails->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'pan' ,'{{ route('admin.driver.update', $driver->userDetails->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bank Account</th>
                                    <td>
                                        @if ($driver->userDetails->bank_account)
                                            @php
                                                $accountStatus = $driver->userDetails->is_account_verified;
                                                if ($accountStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($accountStatus == 'rejected') {
                                                    $status = 'Rejected';
                                                    $clr = 'danger';
                                                    $cls = 'd-none';
                                                } else {
                                                    $status = 'Approved';
                                                    $clr = 'success';
                                                    $cls = 'd-none';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $clr }}">{{ $status }}</span>
                                            <a href="javascript:;" class="btn btn-xs btn-primary"
                                                onclick="documentView('Bank Account','{{ $driver->userDetails->bank_account }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'account' ,'{{ route('admin.driver.update', $driver->userDetails->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'account' ,'{{ route('admin.driver.update', $driver->userDetails->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="documentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modTitle">Document Preview</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body text-center">

                    <div id="documentPreview"></div>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function documentView(doc, fileUrl) {
            let title = document.getElementById('modTitle');
            let preview = document.getElementById('documentPreview');

            title.innerHTML = '';
            preview.innerHTML = '';

            let extension = fileUrl.split('.').pop().toLowerCase();

            // Image types
            let imageExtensions = [
                'jpg',
                'jpeg',
                'png',
                'gif',
                'webp'
            ];

            // PDF
            if (extension === 'pdf') {

                preview.innerHTML = `
                <iframe
                    src="${fileUrl}"
                    width="100%"
                    height="500px"
                    style="border:none;">
                </iframe>
            `;

            }

            // Images
            else if (imageExtensions.includes(extension)) {

                preview.innerHTML = `
                    <img
                        src="${fileUrl}"
                        class=" rounded"
                        alt="Document"  height="auto" width="100%">
                `;

            }

            // Other documents
            else {
                preview.innerHTML = `
                    <a href="${fileUrl}"
                        target="_blank"
                        class="btn btn-primary">Open Document</a>
                    `;
            }
            title.innerHTML = doc;
            $('#documentModal').modal('show');
        }
    </script>
    <script>
        function changeDocStatus(status, docType, updateURL) {
            $.ajax({

                url: updateURL,

                type: "POST",

                data: {

                    _method: "PUT",

                    _token: "{{ csrf_token() }}",

                    status: status,

                    type_of_document: docType,
                },

                beforeSend: function() {
                    $('.doc-status-btn').prop('disabled', true);
                },

                success: function(response) {
                    console.log(response);

                    if (response.status) {

                        alert(response.message);

                        window.location.reload();
                    } else {

                        alert(response.message || 'Something went wrong.');
                    }
                },

                error: function(xhr) {
                    console.log(xhr);

                    let message = 'Something went wrong.';

                    if (xhr.responseJSON?.message) {

                        message = xhr.responseJSON.message;
                    }

                    alert(message);
                },

                complete: function() {
                    $('.doc-status-btn').prop('disabled', false);
                }
            });
        }
    </script>
@endpush
