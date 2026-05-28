@extends('admin.layouts.app')
@section('title', 'Edit Partner')
@section('content')

    <div class="row">
        <div class="col-md-6 mx-auto">
            <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data"
                id="catUploadForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Partner</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group row  mb-2">
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Partner Image </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="drop-area" data-input="partner_image" data-preview="partnerImgPreview"
                                    data-default="{{ $partner->partner_image ?? asset('admin/img/no-img.png') }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="partner_image" name="partner_image" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="partnerImgPreview" width="100">
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Website Url
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="website_url" id="website_url" class="form-control"
                                    value="{{ $partner->website_url }}" placeholder="ex:- google.com">
                            </div>
                        </div>

                        <div class="row">
                            <label class=" col-form-label"></label>
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" id="uploadBtn" class="btn btn-primary px-4"
                                        name="submit2">Update</button>
                                    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary px-4">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
