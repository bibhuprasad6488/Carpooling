@extends('admin.layouts.app')
@section('title', 'Site Setting')
@section('content')
    <div class="container-fluid px-4">
        <div class="py-2 d-none">
            <h1 class="mt-4">Site Setting</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
                <li class="breadcrumb-item ">Site Setting</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="fs-4">Website Setting</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.website-setting.store') }}" class="form-horizontal form-label-left"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <br />
                            <div class="card">
                                <div class="card-header text-center fs-3">
                                    SEO Setting
                                </div>
                                <div class="card-body">

                                    <div class="form-group row  mb-2">
                                        <label for=""
                                            class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site Meta
                                            Title <span>*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="site_title" id="site_title" class="form-control "
                                                value="{{ optional($setting)->site_title }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <label for=""
                                            class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                            Meta
                                            Description</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="site_meta_desc" id="site_meta_desc" class="form-control " placeholder="Meta descripton" rows="3">{{ optional($setting)->site_meta_desc }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <label for=""
                                            class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                            Meta
                                            Keywords</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="site_meta_key" id="site_meta_key" class="form-control " placeholder="Meta keywords" rows="3">{{ optional($setting)->site_meta_key }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group d-none row mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Desctiption</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="site_desc" id="site_desc" class="form-control " rows="3">{{ optional($setting)->site_desc }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Contact
                                    No
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="contact_phone" id="contact_phone" class="form-control "
                                        value="{{ optional($setting)->contact_phone }}" required>
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for="firstname" class="d-flex justify-content-end col-md-3 col-sm-3 col-xs-12">
                                    Email ID </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" name="contact_email" id="contact_email" class="form-control "
                                        value="{{ optional($setting)->contact_email }}">
                                </div>
                            </div>
                            <div class="form-group row d-none  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Alt.
                                    Contact No
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="alt_phone" id="alt_phone" class="form-control "
                                        value="{{ optional($setting)->alt_phone }}">
                                </div>
                            </div>
                            <div class="form-group row d-none  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Call/Whatsapp No
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="call_wp_number" id="call_wp_number" class="form-control "
                                        value="{{ optional($setting)->call_wp_number }}">
                                </div>
                            </div>
                            <div class="form-group row d-none mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Whatsapp Message
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="wp_message" id="wp_message" class="form-control " rows="3">{{ optional($setting)->wp_message }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row d-none  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Alt.
                                    Email</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" name="alt_email" id="alt_email" class="form-control "
                                        value="{{ optional($setting)->alt_email }}">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    Logo (Drag & Drop)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="drop-area" data-input="site_logo" data-preview="siteLogoPreview"
                                        data-default="{{ $setting->site_logo ?? asset('admin/img/no-img.png') }}">
                                        <p>Drag & Drop Image Here or Click to Select</p>
                                        <input type="file" id="site_logo" name="site_logo" hidden
                                            accept=".jpg,.jpeg,.png,.webp">

                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <img src="" id="siteLogoPreview" width="150">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    Footer Logo (Drag & Drop)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="drop-area" data-input="footer_logo" data-preview="footerLogoPreview"
                                        data-default="{{ $setting->footer_logo ?? asset('admin/img/no-img.png') }}">
                                        <p>Drag & Drop Image Here or Click to Select</p>
                                        <input type="file" id="footer_logo" name="footer_logo" hidden
                                            accept=".jpg,.jpeg,.png,.webp">

                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <img src="" id="footerLogoPreview" width="100" class="p-1">
                                </div>
                            </div>

                            <div class="form-group row d-none mb-2">
                                <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    Footer Logo One (Drag & Drop)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="drop-area" data-input="footer_logo_one"
                                        data-preview="footerLogoOnePreview"
                                        data-default="{{ $setting->footer_logo_one ?? asset('admin/img/no-img.png') }}">
                                        <p>Drag & Drop Image Here or Click to Select</p>
                                        <input type="file" id="footer_logo_one" name="footer_logo_one" hidden
                                            accept=".jpg,.jpeg,.png,.webp">

                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <img src="" id="footerLogoOnePreview" width="100">
                                </div>
                            </div>
                            <div class="form-group row d-none  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Footer
                                    Logo Two</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="footer_logo_two" id="footer_logo_two"
                                        class="form-control ">
                                    <img @if ($setting && $setting->footer_logo_two) src="{{ $setting->footer_logo_two }}"
                                    @else style="display: none;" @endif
                                        alt="Site Logo" width="100">
                                </div>
                            </div>

                            <div class="form-group row  mb-2">
                                <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    Favicon (Drag & Drop)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="drop-area" data-input="favicon" data-preview="faviconPreview"
                                        data-default="{{ $setting->favicon ?? asset('admin/img/no-img.png') }}">
                                        <p>Drag & Drop Image Here or Click to Select</p>
                                        <input type="file" id="favicon" name="favicon" hidden
                                            accept=".jpg,.jpeg,.png,.webp">

                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <img src="" id="faviconPreview" width="50">
                                </div>
                            </div>

                            <div class="form-group row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    Address
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="address" id="address" class="form-control " rows="3">{{ optional($setting)->address }}</textarea>
                                </div>
                            </div>

                            <div class="form-group  row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    Location
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="site_map_key" id="site_map_key" class="form-control " rows="7" placeholder="Iframe link">{{ optional($setting)->site_map_key }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row d-none mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    CTA Title </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="cta_title" id="cta_title" class="form-control "
                                        value="{{ optional($setting)->cta_title }}" placeholder="CTA Title">
                                </div>
                            </div>
                            <div class="form-group row d-none mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    CTA Sub Title</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="cta_sub_title" id="cta_sub_title" class="form-control "
                                        value="{{ optional($setting)->cta_sub_title }}" placeholder="CTA Sub Title">
                                </div>
                            </div>
                            <div class="form-group row d-none  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Footer Text</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="footer_text_one" id="footer_text_one" class="form-control " rows="3">{{ optional($setting)->footer_text_one }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row d-none mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Footer Text Two</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="footer_text_two" id="cont" class="form-control " rows="3">{{ optional($setting)->footer_text_two }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Commission (%)
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="number" name="commision" id="commision" class="form-control "
                                        value="{{ optional($setting)->commision }}" required>
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Copyrights
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="copyright" id="copyright" class="form-control "
                                        value="{{ optional($setting)->copyright }}" required>
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    Host
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_host" id="smtp_host" class="form-control "
                                        value="{{ optional($setting)->smtp_host }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    Port
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_port" id="smtp_port" class="form-control "
                                        value="{{ optional($setting)->smtp_port }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    Username
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_username" id="smtp_username" class="form-control "
                                        value="{{ optional($setting)->smtp_username }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    Password
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_password" id="smtp_password" class="form-control "
                                        value="{{ optional($setting)->smt_password }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    From
                                    Name
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_from_name" id="smtp_from_name"
                                        class="form-control " value="{{ optional($setting)->smtp_from_name }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    From
                                    Email
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_from_email" id="smtp_from_email"
                                        class="form-control " value="{{ optional($setting)->smtp_from_email }}">
                                </div>
                            </div>


                            <hr />
                            <div class="row">
                                <label class=" col-form-label"></label>
                                <div class="d-flex justify-content-center">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" id="submitBtn1" class="btn btn-primary px-4"
                                            name="submit2">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function previewSiteLogoImage(event) {
            const input = event.target;
            const preview = document.getElementById('siteLogoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewFooterLogoImage(event) {
            const input = event.target;
            const preview = document.getElementById('footerLogoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewFaviconImage(event) {
            const input = event.target;
            const preview = document.getElementById('faviconPreview');

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#cont').summernote({
                placeholder: 'Content',
                tabsize: 2,
                height: 300,
                color: {
                    background: '#ffffff',
                    foreground: '#000000',
                }
            });
        });
    </script>
@endpush
