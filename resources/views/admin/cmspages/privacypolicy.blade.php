@extends('admin.layouts.app')
@section('title', 'Privacy Policy')
@section('content')
    <div class="container-fluid px-4">
            <div class="py-2 d-none">
                <h1 class="mt-4">Privacy Policy</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Privacy Policy</li>
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
                Privacy policy Information
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Description -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Contnt
                            </label>
                            <textarea name="content" rows="4" class="form-control " id="summernote" placeholder="Content">{{ $privacy->content ?? old('content') }}</textarea>
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
            // Loop through all elements with the class 'cont'
            document.querySelectorAll(".cont").forEach(function(editor) {

                // Initialize TinyMCE for each editor
                tinymce.init({
                    target: editor, // Use 'target' to bind TinyMCE to the specific element
                    height: 600,
                    plugins: 'advlist autolink link image lists charmap preview code fullscreen',
                    toolbar: 'undo redo | blocks | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright | bullist numlist blockquote | link image | code fullscreen ',

                    // NEW: use "blocks" instead of "formatselect" in TinyMCE 6+
                    block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre; Blockquote=blockquote',

                    setup: function(editorInstance) {
                        // Sync content
                        editorInstance.on('change', function() {
                            editor.value = editorInstance.getContent();
                        });
                    }
                });
            });
        });
    </script>
@endpush
