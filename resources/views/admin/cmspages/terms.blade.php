@extends('admin.layouts.app')
@section('title', 'Terms Of Business')
@section('content')
    <div class="container-fluid px-4">
        <div class="py-2 d-none">
            <h1 class="mt-4">Terms Of Business</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">Terms Of Business</li>
            </ol>
        </div>
        <div class="ms-auto d-none">
            <div class="btn-group">
                <a href="#" class="btn btn-primary">Add</a>
            </div>
        </div>
        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-semibold fs-4">
                Terms Of Business Information
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.terms-and-condition.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Description -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Contnt
                            </label>
                            <textarea name="content" rows="4" class="form-control" id="cont" placeholder="Content">{{ $term->content ?? old('content') }}</textarea>
                        </div>

                    </div>

                    <!-- Actions -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .tox-editor-container {
            border: 1px solid #adb5bd !important;
        }
    </style>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#cont').summernote({
                placeholder: 'Content',
                tabsize: 2,
                height: 600
            });
        });
    </script>
@endpush
