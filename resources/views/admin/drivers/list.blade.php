@extends('admin.layouts.app')
@section('title', 'Drivers')
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
                    <h4 class="card-title">Drivers</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Profile Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Register Date</th>
                                    <th>Profile Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $d)
                                    @php
                                        $userDetails = $d->userDetails;
                                        if ($userDetails && $userDetails->is_verified == 0) {
                                            $status = $userDetails->status;
                                            if ($status == 'pending') {
                                                $clr = 'warning';
                                            } else {
                                                $clr = 'danger';
                                            }
                                        } else {
                                            $status = 'Verified';
                                            $clr = 'primary';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img @if ($userDetails && $userDetails->profile_picture) src="{{ $userDetails->profile_picture }}"
                                        @else
                                            src="{{ asset('admin/img/no-img.png') }}" @endif
                                                alt="Partner" width="50" class="circle">
                                        </td>
                                        <td>{{ ucfirst($d->name) }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->phone }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}</td>
                                        <td><span class="badge bg-{{ $clr }}">{{ ucfirst($status) }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.driver.show', $d->id) }}"
                                                class="btn btn-xs btn-success "><i class="far fa-eye"></i></a>
                                            {{-- <form action="{{ route('admin.driver.destroy', $d->id) }}" method="POST"
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
