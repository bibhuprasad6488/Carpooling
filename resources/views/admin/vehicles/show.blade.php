@extends('admin.layouts.app')
@section('title', 'Vehicle Details')
@section('content')

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 ">
        <div>
            <h3 class="fw-bold mb-3 d-none">Home Page</h3>
        </div>
        <div class="ms-md-auto d-none py-2 py-md-0">
            <a href="{{ route('admin.vehicle.create') }}" class="btn btn-primary">Add Partner</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-car"></i> Vehicle Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="fs-6">Vehicle No</th>
                                    <td class="fs-5">{{ $vehicle->registration_number }}</td>
                                </tr>
                                <tr>
                                    <th class="fs-6">Brand</th>
                                    <td class="fs-5">{{ ucfirst($vehicle->brand) }}</td>
                                </tr>
                                <tr>
                                    <th class="fs-6">Model</th>
                                    <td class="fs-5">{{ ucfirst($vehicle->model) }}</td>
                                </tr>
                                <tr>
                                    <th class="fs-6">Manufacture Year</th>
                                    <td class="fs-5">{{ $vehicle->manufacture_year }}</td>
                                </tr>
                                <tr>
                                    <th class="fs-6">Register At: </th>
                                    <td class="fs-5">
                                        {{ \Carbon\Carbon::parse($vehicle->created_at)->format('d-m-Y h:i A') }}</td>
                                    </td>
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
                    <h4 class="card-title"><i class="fas fa-user-check"></i> Driver Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <td>
                                        {{ ucfirst($vehicle->driver->name ?? 'N/A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $vehicle->driver->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ ucfirst($vehicle->driver->phone ?? 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>Postal Code</th>
                                    <td>{{ $vehicle->driver->userDetails->postal_code ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ ucfirst($vehicle->driver->userDetails->address ?? 'N/A') }}</td>
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
                    <h4 class="card-title"><i class="fas fa-clipboard-list"></i> Vehicle Documents</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>RC File</th>
                                    <td>
                                        @if ($vehicle->rc_file)
                                            @php
                                                $rcFileStatus = $vehicle->is_rc_verified;
                                                if ($rcFileStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($rcFileStatus == 'rejected') {
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
                                                onclick="documentView('RC File','{{ $vehicle->rc_file }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'rc' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'rc' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Insurance File</th>
                                    <td>
                                        @if ($vehicle->insurance_file)
                                            @php
                                                $insuranceFileStatus = $vehicle->is_insurance_verified;
                                                if ($insuranceFileStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($insuranceFileStatus == 'rejected') {
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
                                                onclick="documentView('Insurance File','{{ $vehicle->insurance_file }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'insurance' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'insurance' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Number Plate</th>
                                    <td>
                                        @if ($vehicle->number_plate_image)
                                            @php
                                                $numberPlateStatus = $vehicle->is_number_plate_verified;
                                                if ($numberPlateStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($numberPlateStatus == 'rejected') {
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
                                                onclick="documentView('Number Plate','{{ $vehicle->number_plate_image }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'number_plate' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'number_plate' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Front Image</th>
                                    <td>
                                        @if ($vehicle->front_image)
                                            @php
                                                $fontImageStatus = $vehicle->is_front_image_verified;
                                                if ($fontImageStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($fontImageStatus == 'rejected') {
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
                                                onclick="documentView('Front Image','{{ $vehicle->front_image }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'front_image' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'front_image' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Back Image</th>
                                    <td>
                                        @if ($vehicle->back_image)
                                            @php
                                                $fontImageStatus = $vehicle->is_back_image_verified;
                                                if ($fontImageStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($fontImageStatus == 'rejected') {
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
                                                onclick="documentView('Back Image','{{ $vehicle->back_image }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'back_image' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'back_image' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Reject</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Side Image</th>
                                    <td>
                                        @if ($vehicle->side_image)
                                            @php
                                                $fontImageStatus = $vehicle->is_side_image_verified;
                                                if ($fontImageStatus == 'pending') {
                                                    $status = 'Pending';
                                                    $clr = 'warning';
                                                    $cls = '';
                                                } elseif ($fontImageStatus == 'rejected') {
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
                                                onclick="documentView('Side Image','{{ $vehicle->side_image }}')">View</a>
                                            <a href="javascript:;" class="btn btn-xs btn-success {{ $cls }}"
                                                onclick="changeDocStatus('approved', 'side_image' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Approve</a>
                                            <a href="javascript:;" class="btn btn-xs btn-danger {{ $cls }}"
                                                onclick="changeDocStatus('rejected', 'side_image' ,'{{ route('admin.vehicle.update', $vehicle->id) }}')">Reject</a>
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
