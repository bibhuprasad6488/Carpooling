@extends('admin.layouts.app')
@section('title', 'Protection Page')
@section('content')

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 d-none">
        <div>
            <h3 class="fw-bold mb-3">Home Page</h3>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
            <a href="{{ route('admin.protection-page.create') }}" class="btn btn-primary btn-round">Add Customer</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.introducer-details-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Become An Introducer Banner Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="banner_title" id="banner_title" class="form-control "
                                    value="{{ optional($intDetails)->banner_title ?? old('banner_title') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                Desc <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="banner_desc" id="banner_desc" class="form-control " rows="3">{{ optional($intDetails)->banner_desc ?? old('banner_desc') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                Btn Text <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="banner_btn_text" id="banner_btn_text" class="form-control "
                                    value="{{ optional($intDetails)->banner_btn_text ?? old('banner_btn_text') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Banner Image </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="banner_image"
                                    data-preview="bannerImagePreview"
                                    data-default="{{ $intDetails->banner_image ?? asset('admin/img/no-img.png') }}">
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
                        <h4 class="card-title text-center">Why Partner One</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="wpwm_icon_one"
                                    data-preview="wpwmOnePreview"
                                    data-default="{{ $intDetails->wpwm_icon_one ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="wpwm_icon_one" name="wpwm_icon_one" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="wpwmOnePreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_title_one" id="wpwm_title_one" class="form-control "
                                    value="{{ optional($intDetails)->wpwm_title_one ?? old('wpwm_title_one') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_subtitle_one" id="wpwm_subtitle_one" class="form-control "
                                    value="{{ optional($intDetails)->wpwm_subtitle_one ?? old('wpwm_subtitle_one') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Why Partner Two</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="wpwm_icon_two"
                                    data-preview="wpwmTwoPreview"
                                    data-default="{{ $intDetails->wpwm_icon_two ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="wpwm_icon_two" name="wpwm_icon_two" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="wpwmTwoPreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_title_two" id="wpwm_title_two" class="form-control "
                                    value="{{ optional($intDetails)->wpwm_title_two ?? old('wpwm_title_two') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_subtitle_two" id="wpwm_subtitle_two"
                                    class="form-control "
                                    value="{{ optional($intDetails)->wpwm_subtitle_two ?? old('wpwm_subtitle_two') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Why Partner Three</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="wpwm_icon_three"
                                    data-preview="wpwmThreePreview"
                                    data-default="{{ $intDetails->wpwm_icon_three ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="wpwm_icon_three" name="wpwm_icon_three" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="wpwmThreePreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_title_three" id="wpwm_title_three"
                                    class="form-control "
                                    value="{{ optional($intDetails)->wpwm_title_three ?? old('wpwm_title_three') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_subtitle_three" id="wpwm_subtitle_three"
                                    class="form-control "
                                    value="{{ optional($intDetails)->wpwm_subtitle_three ?? old('wpwm_subtitle_three') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Why Partner Four</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="wpwm_icon_four"
                                    data-preview="wpwmFourPreview"
                                    data-default="{{ $intDetails->wpwm_icon_four ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="wpwm_icon_four" name="wpwm_icon_four" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="wpwmFourPreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_title_four" id="wpwm_title_four" class="form-control "
                                    value="{{ optional($intDetails)->wpwm_title_four ?? old('wpwm_title_four') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_subtitle_four" id="wpwm_subtitle_four"
                                    class="form-control "
                                    value="{{ optional($intDetails)->wpwm_subtitle_four ?? old('wpwm_subtitle_four') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Why Partner Five</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="wpwm_icon_five"
                                    data-preview="wpwmFivePreview"
                                    data-default="{{ $intDetails->wpwm_icon_five ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="wpwm_icon_five" name="wpwm_icon_five" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="wpwmFivePreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_title_five" id="wpwm_title_five" class="form-control "
                                    value="{{ optional($intDetails)->wpwm_title_five ?? old('wpwm_title_five') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="wpwm_subtitle_five" id="wpwm_subtitle_five"
                                    class="form-control "
                                    value="{{ optional($intDetails)->wpwm_subtitle_five ?? old('wpwm_subtitle_five') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Our Process One</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="sp_icon_one"
                                    data-preview="spOnePreview"
                                    data-default="{{ $intDetails->sp_icon_one ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="sp_icon_one" name="sp_icon_one" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="spOnePreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_title_one" id="sp_title_one" class="form-control "
                                    value="{{ optional($intDetails)->sp_title_one ?? old('sp_title_one') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_subtitle_one" id="sp_subtitle_one" class="form-control "
                                    value="{{ optional($intDetails)->sp_subtitle_one ?? old('sp_subtitle_one') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Our Process Two</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="sp_icon_two"
                                    data-preview="spTwoPreview"
                                    data-default="{{ $intDetails->sp_icon_two ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="sp_icon_two" name="sp_icon_two" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="spTwoPreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_title_two" id="sp_title_two" class="form-control "
                                    value="{{ optional($intDetails)->sp_title_two ?? old('sp_title_two') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_subtitle_two" id="sp_subtitle_two" class="form-control "
                                    value="{{ optional($intDetails)->sp_subtitle_two ?? old('sp_subtitle_two') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Our Process Three</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="sp_icon_three"
                                    data-preview="spThreePreview"
                                    data-default="{{ $intDetails->sp_icon_three ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="sp_icon_three" name="sp_icon_three" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="spThreePreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_title_three" id="sp_title_three" class="form-control "
                                    value="{{ optional($intDetails)->sp_title_three ?? old('sp_title_three') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_subtitle_three" id="sp_subtitle_three"
                                    class="form-control "
                                    value="{{ optional($intDetails)->sp_subtitle_three ?? old('sp_subtitle_three') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Our Process Four</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="sp_icon_four"
                                    data-preview="spFourPreview"
                                    data-default="{{ $intDetails->sp_icon_four ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="sp_icon_four" name="sp_icon_four" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="spFourPreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_title_four" id="sp_title_four" class="form-control "
                                    value="{{ optional($intDetails)->sp_title_four ?? old('sp_title_four') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_subtitle_four" id="sp_subtitle_four"
                                    class="form-control "
                                    value="{{ optional($intDetails)->sp_subtitle_four ?? old('sp_subtitle_four') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Our Process Five</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Icon </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" id="dropArea" data-input="sp_icon_five"
                                    data-preview="spFivePreview"
                                    data-default="{{ $intDetails->sp_icon_five ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="sp_icon_five" name="sp_icon_five" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="spFivePreview" width="60">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_title_five" id="sp_title_five" class="form-control "
                                    value="{{ optional($intDetails)->sp_title_five ?? old('sp_title_five') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Sub Title <span>*</span>
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="sp_subtitle_five" id="sp_subtitle_five"
                                    class="form-control "
                                    value="{{ optional($intDetails)->sp_subtitle_five ?? old('sp_subtitle_five') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">SEO Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Meta
                                Title
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="meta_title" id="meta_title" class="form-control "
                                    value="{{ optional($intDetails)->meta_title ?? old('meta_title') }}" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Meta
                                Description
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="meta_desc" id="meta_desc" class="form-control " rows="3">{{ optional($intDetails)->meta_desc ?? old('meta_desc') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Meta
                                Keywords
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="meta_keywords" id="meta_keywords" class="form-control " rows="3">{{ optional($intDetails)->meta_keywords ?? old('meta_keywords') }}</textarea>

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
    </div>
@endsection
