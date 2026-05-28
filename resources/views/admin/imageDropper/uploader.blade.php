<div class="form-group row  mb-2">
    <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
        Banner Image (Drag & Drop)</label>
    <div class="col-md-6 col-sm-6 col-xs-12">

        <div class="drop-area" data-input="{{ $inputName }}" data-preview="{{ $preview_name }}"
            data-default="{{ $def_img }}">
            <p>Drag & Drop Image Here or Click to Select</p>
            <input type="file" id="{{ $inputName }}" name="{{ $inputName }}" hidden
                accept=".jpg,.jpeg,.png,.webp">

        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <img src="" id="{{ $preview_name }}" width="100">
    </div>
</div>

<!-- Include that in blade file and the name values accordinglly -->
{{-- @include('admin.imageDropper.uploader', [
    'inputName' => 'service_image',
    'preview_name' => 'serviceImgPreview',
    'def_img' => asset('admin/img/no-img.png'),
]) --}}
