@extends('admin.layouts.app')
@section('title', 'Introducer Page')
@section('content')

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 d-none">
        <div>
            <h3 class="fw-bold mb-3">Home Page</h3>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
            <a href="{{ route('admin.become-introducer.create') }}" class="btn btn-primary btn-round">Add Customer</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.become-introducer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Introducer Banner Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="banner_title" id="banner_title" class="form-control "
                                    value="{{ optional($introducer)->banner_title ?? old('banner_title') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                Desc <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="banner_desc" id="banner_desc" class="form-control " rows="3">{{ optional($introducer)->banner_desc ?? old('banner_desc') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                Btn Text <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="banner_btn_text" id="banner_btn_text" class="form-control "
                                    value="{{ optional($introducer)->banner_btn_text ?? old('banner_btn_text') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Banner Image </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="banner_image"
                                    data-preview="bannerImagePreview"
                                    data-default="{{ $introducer->banner_image ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="banner_image" name="banner_image" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="bannerImagePreview" width="150">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Why Partner With Us?</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Left
                                Content <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="wpwu_content" id="summernote" class="" rows="5">{{ optional($introducer)->wpwu_content }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Image </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="wpwu_image"
                                    data-preview="wpwuImagePreview"
                                    data-default="{{ $introducer->wpwu_image ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="wpwu_image" name="wpwu_image" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="wpwuImagePreview" width="150">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">How it Works One</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="hw_icon_one" data-preview="hwOnePreview"
                                    data-default="{{ $introducer->hw_icon_one ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="hw_icon_one" name="hw_icon_one" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="hwOnePreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hw_title_one" id="hw_title_one" class="form-control "
                                    value="{{ optional($introducer)->hw_title_one ?? old('hw_title_one') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hw_subtitle_one" id="hw_subtitle_one" class="form-control "
                                    value="{{ optional($introducer)->hw_subtitle_one ?? old('hw_subtitle_one') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">How it Works Two</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Feature Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="hw_icon_two"
                                    data-preview="hwTwoPreview"
                                    data-default="{{ $introducer->hw_icon_two ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="hw_icon_two" name="hw_icon_two" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="hwTwoPreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Feature
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hw_title_two" id="hw_title_two" class="form-control "
                                    value="{{ optional($introducer)->hw_title_two ?? old('hw_title_two') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Feature
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hw_subtitle_two" id="hw_subtitle_two" class="form-control "
                                    value="{{ optional($introducer)->hw_subtitle_two ?? old('hw_subtitle_two') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">How it Works Three</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="hw_icon_three"
                                    data-preview="hwThreePreview"
                                    data-default="{{ $introducer->hw_icon_three ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="hw_icon_three" name="hw_icon_three" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="hwThreePreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hw_title_three" id="hw_title_three" class="form-control "
                                    value="{{ optional($introducer)->hw_title_three ?? old('hw_title_three') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hw_subtitle_three" id="hw_subtitle_three"
                                    class="form-control "
                                    value="{{ optional($introducer)->hw_subtitle_three ?? old('hw_subtitle_three') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">How it Works Four</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="hw_icon_four"
                                    data-preview="hwFourPreview"
                                    data-default="{{ $introducer->hw_icon_four ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="hw_icon_four" name="hw_icon_four" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="hwFourPreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hw_title_four" id="hw_title_four" class="form-control "
                                    value="{{ optional($introducer)->hw_title_four ?? old('hw_title_four') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hw_subtitle_four" id="hw_subtitle_four"
                                    class="form-control "
                                    value="{{ optional($introducer)->hw_subtitle_four ?? old('hw_subtitle_four') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">SEO Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Meta
                                Title
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="meta_title" id="meta_title" class="form-control "
                                    value="{{ optional($introducer)->meta_title ?? old('meta_title') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Meta
                                Description
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="meta_desc" id="meta_desc" class="form-control " rows="3">{{ optional($introducer)->meta_desc ?? old('meta_desc') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Meta
                                Keywords
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="meta_keywords" id="meta_keywords" class="form-control " rows="3">{{ optional($introducer)->meta_keywords ?? old('meta_keywords') }}</textarea>

                            </div>
                        </div>

                        <div class="row">
                            <label class=" col-form-label"></label>
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" id="submitBtn1" class="btn btn-primary px-4"
                                        name="submit2">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ route('admin.store-int-type') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Introducer Type Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="title" id="title" class="form-control "
                                    value="{{ old('title') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="icon"
                                    data-preview="intIconImagePreview"
                                    data-default="{{ asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="icon" name="icon" hidden
                                        accept=".jpg,.jpeg,.png,.webp" required>

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="intIconImagePreview" width="150">
                            </div>
                        </div>

                        <div class="row">
                            <label class=" col-form-label"></label>
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" id="submitBtn1" class="btn btn-primary px-4"
                                        name="submit2">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-12">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="dataTable"
                                                class="display table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sl,No</th>
                                                        <th>Title</th>
                                                        <th>Icon</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($intTypes as $int)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $int->title }}</td>
                                                            <td>
                                                                <img @if ($int && $int->icon) src="{{ $int->icon }}"@else
                                                            src="{{ asset('admin/img/no-img.png') }}" @endif
                                                                    alt="Partner" width="30" class="rounded">
                                                            </td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('admin.become-introducer.destroy', $int->id) }}"
                                                                    method="POST" style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                                        onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                                                </form>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function previewBannerLogoImage(event) {
            const input = event.target;
            const preview = document.getElementById('bannerLogoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
