@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Hỗ trợ',
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link  fw-bold" id="info-tab" href="{{ route('admin.banners.index') }}">Banner</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link  fw-bold" id="seo-tab" href="{{ route('admin.journey.index') }}">Tháo gỡ khó khăn</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link  fw-bold" id="seo-tab" href="{{ route('admin.issues.index') }}">Khó khăn trong kinh doanh</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" href="{{ route('admin.configs.index') }}">Thông tin công ty</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active fw-bold" id="seo-tab" href="{{ route('admin.seo.index') }}">Seo</a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" href="">Cấu hình tư vẫn</a>
        </li>

    </ul>



    <div class="card-body" style="background: #ffffff !important;">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <form action="{{ route('admin.seo.store') }}" method="post" enctype="multipart/form-data"
                                id="myForm">
                                @csrf
                                <div class="tab-pane fade show active" aria-labelledby="info-tab">
                                    <div class="row">

                                        <div class="form-group mb-3">
                                            <label for="title_seo" class="form-label">Tiêu đề seo</label>
                                            <input type="text" value="{{ $config->title_seo }}" placeholder="Tiêu đề seo"
                                                id="title_seo" name="title_seo" class="form-control">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="description_seo" class="form-label">Mô tả seo</label>
                                            <textarea name="description_seo" id="description_seo" cols="30" rows="4" class="form-control ckeditor"
                                                placeholder="Mô tả seo">{{ $config->description_seo }}</textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="keyword_seo" class="form-label">Từ khóa seo</label>
                                            <input id="keyword_seo" value="{{ $config->keyword_seo }}" name="keyword_seo">
                                        </div>



                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" id="btnSave" class="btn btn-primary">Lưu</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('backend/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/tagify.min.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {

            var input = document.querySelector('#keyword_seo');
            var tagify = new Tagify(input, {
                maxTags: 10,
                placeholder: "Nhập từ khóa...",
            });

            var input_tags = document.querySelector('#tags');
            var tagify_tags = new Tagify(input_tags, {
                maxTags: 10,
                placeholder: "Nhập tags...",
            });
            ckeditor('description_seo')
        });
    </script>
@endpush
