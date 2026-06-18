@extends('admin.layouts.app')
@section('title', 'Bookings')
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Bookings</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Driver</th>
                                    <th>Source</th>
                                    <th>Destination</th>
                                    <th>Ride Date</th>
                                    <th>Deparature Time</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rides as $r)
                                    @php
                                        $rideDateTime = \Carbon\Carbon::parse($r->ride_date . ' ' . $r->departure_time);

                                        if ($r->status == 'scheduled') {
                                            if ($rideDateTime->isPast()) {
                                                $clr = 'danger';
                                                $status = 'Expired';
                                            } else {
                                                $clr = 'warning';
                                                $status = 'Upcoming';
                                            }
                                        } else {
                                            $clr = 'success';
                                            $status = ucfirst($r->status);
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucfirst($r->driver->name) }}</td>
                                        <td>
                                            <span title="{{ $r->source_address }}">
                                                {{ Str::limit($r->source_address, 20, '....') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span title="{{ $r->destination_address }}">
                                                {{ Str::limit($r->destination_address, 20, '....') }}
                                            </span>
                                        </td>
                                        <td>{{ $r->ride_date }}</td>
                                        <td>{{ \Carbon\Carbon::parse($r->departure_time)->format('H:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d-m-Y') }}</td>
                                        <td><span class="badge bg-{{ $clr }}">{{ ucfirst($status) }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.rides.show', $r->id) }}"
                                                class="btn btn-xs btn-success "><i class="far fa-eye"></i></a>
                                            {{-- <form action="{{ route('admin.driver.destroy', $r->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
