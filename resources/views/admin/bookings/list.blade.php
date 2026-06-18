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
                                    <th>Booking ID</th>
                                    <th>Passenger</th>
                                    <th>Total Seats</th>
                                    <th>Amount</th>
                                    <th>Ride Date</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $b)
                                    @php
                                        $status = $b->status;
                                        if ($status == 'pending') {
                                            $clr = 'warning';
                                        } elseif ($status == 'confirmed') {
                                            $clr = 'success';
                                        } else {
                                            $clr = 'danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $b->booking_code }}</td>
                                        <td>{{ ucfirst($b->passenger->name) }}</td>
                                        <td>
                                            {{ $b->seats }}
                                        </td>
                                        <td>{{ $b->total_price }}</td>
                                        <td>{{ $b->ride_date }}</td>
                                        <td>{{ \Carbon\Carbon::parse($b->created_at)->format('d-m-Y') }}</td>
                                        <td><span class="badge bg-{{ $clr }}">{{ ucfirst($status) }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $b->id) }}"
                                                class="btn btn-xs btn-success "><i class="far fa-eye"></i></a>
                                            {{-- <form action="{{ route('admin.driver.destroy', $b->id) }}" method="POST"
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
