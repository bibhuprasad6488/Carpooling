<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $setting = \App\Models\SiteSetting::find(1);
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon"
        href="@if ($setting) {{ asset('storage/images/settings/' . $setting->favicon) }} @else {{ asset('admin/img/favicon.png') }} @endif"
        type="image/x-icon" />

    <!-- Fonts -->
    <script src="{{ asset('admin/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('admin/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/fonts.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/demo.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

    <link href="{{ asset('admin/assets/summernote/summernote.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .fade-notify {
            opacity: 1;
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .fade-notify.hide {
            opacity: 0;
            transform: translateY(-10px);
        }

        .drop-area {
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .drop-area.dragover {
            background-color: #f0f8ff;
        }

        .preview img {
            width: 120px;
            margin: 10px;
            border-radius: 6px;
        }

        .note-editor.note-frame {
            border: 1px solid #6c757d !important;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')

        <div class="main-panel">

            {{-- Navbar --}}
            @include('admin.layouts.nav')

            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <!-- Core JS -->
    <script src="{{ asset('admin/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/js/core/bootstrap.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/chart.js/chart.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script> --}}
    <script src="{{ asset('admin/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('admin/js/kaiadmin.min.js') }}"></script>

    <script src="{{ asset('admin/assets/summernote/summernote.min.js') }}"></script>
    <!-- Bootstrap Notify -->
    <script src="{{ asset('admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <!-- Feather Icons (for navbar icons) -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('dataTable');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#summernote').summernote({
                placeholder: 'Content',
                tabsize: 2,
                height: 500,
                border: "1px solid #000"
            });
            // // Loop through all elements with the class 'tinymce-editor'
            // document.querySelectorAll(".tinymce-editor").forEach(function(editor) {

            //     // Initialize TinyMCE for each editor
            //     tinymce.init({
            //         target: editor, // Use 'target' to bind TinyMCE to the specific element
            //         height: 500,
            //         plugins: 'advlist autolink link image lists charmap preview code fullscreen',
            //         toolbar: 'undo redo | blocks | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright | bullist numlist blockquote | link image | code fullscreen ',

            //         // NEW: use "blocks" instead of "formatselect" in TinyMCE 6+
            //         block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre; Blockquote=blockquote',

            //         setup: function(editorInstance) {
            //             // Sync content
            //             editorInstance.on('change', function() {
            //                 editor.value = editorInstance.getContent();
            //             });
            //         }
            //     });
            // });
        });
    </script>
    @if (session('success') || session('error'))
        <script>
            $(function() {

                let message = "{{ session('success') ?? session('error') }}";
                let type = "{{ session('success') ? 'success' : 'danger' }}";

                $.notify({
                    title: message,
                    message: '',
                    icon: "{{ session('success') ? 'fa fa-bell' : 'fa fa-exclamation' }}"
                }, {
                    type: type,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    delay: 3000, // ⏱ auto close after 3 sec
                    timer: 1000, // ⏱ animation timing
                    z_index: 9999,
                    mouse_over: 'pause',
                    animate: {
                        enter: 'fade-notify',
                        exit: 'fade-notify hide'
                    }
                });

            });
        </script>
    @endif
    <script>
        $("#displayNotif").on("click", function() {
            var placementFrom = $("#notify_placement_from option:selected").val();
            var placementAlign = $("#notify_placement_align option:selected").val();
            var state = $("#notify_state option:selected").val();
            var style = $("#notify_style option:selected").val();
            var content = {};

            content.message =
                'sdf';
            content.title = "Bootstrap notify";
            if (style == "withicon") {
                content.icon = "fa fa-bell";
            } else {
                content.icon = "none";
            }
            content.url = "#";
            content.target = "_blank";

            $.notify(content, {
                type: state,
                placement: {
                    from: placementFrom,
                    align: placementAlign,
                },
                time: 1000,
                delay: 0,
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            const maxSize = 3 * 1024 * 1024; // 3MB

            document.querySelectorAll('.drop-area').forEach(zone => {

                const inputId = zone.dataset.input;
                const previewId = zone.dataset.preview;
                const defaultImage = zone.dataset.default;

                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                // ✅ 1. Set default image on load
                if (defaultImage && preview) {
                    preview.src = defaultImage;
                }

                // ✅ 2. Click to open file dialog
                zone.addEventListener('click', () => input.click());

                // ✅ 3. File select (normal upload)
                input.addEventListener('change', () => {
                    handleFile(input.files[0], preview);
                });

                // ✅ 4. Drag over
                zone.addEventListener('dragover', e => {
                    e.preventDefault();
                    zone.classList.add('dragover');
                });

                // ✅ 5. Drag leave
                zone.addEventListener('dragleave', () => {
                    zone.classList.remove('dragover');
                });

                // ✅ 6. Drop file
                zone.addEventListener('drop', e => {
                    e.preventDefault();
                    zone.classList.remove('dragover');

                    const droppedFile = e.dataTransfer.files[0];

                    if (!droppedFile) return;

                    // Sync dropped file with input (important for form submit)
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(droppedFile);
                    input.files = dataTransfer.files;

                    handleFile(droppedFile, preview);
                });

            });

            // ✅ Common file handler
            function handleFile(file, preview) {

                if (!file) return;

                // Type validation
                if (!allowedTypes.includes(file.type)) {
                    alert("Only JPG, JPEG, PNG, WEBP files are allowed.");
                    return;
                }

                // Size validation
                if (file.size > maxSize) {
                    alert("Maximum allowed size is 2MB.");
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview) {
                        preview.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }

        });
    </script>

    <script>
        window.onload = function() {
            let alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }
        };
    </script>
    @stack('scripts')
</body>

</html>
