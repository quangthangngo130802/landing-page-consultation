@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Tháo gỡ khó khăn',
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link  fw-bold" id="info-tab" href="{{ route('admin.banners.index') }}">Banner</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active fw-bold" id="seo-tab">Tháo gỡ khó khăn</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link  fw-bold" id="seo-tab" href="{{ route('admin.issues.index') }}">Khó khăn trong kinh doanh</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" href="{{ route('admin.configs.index') }}">Thông tin công ty</a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" href="{{ route('admin.seo.index') }}">Seo</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" href="">Cấu hình tư vẫn</a>
        </li>
    </ul>



    <form action="{{ route('admin.journey.store') }}" method="post" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" aria-labelledby="info-tab">
                                <div class="row">
                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="name" class="form-label">Tiêu đề <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $journey->title ?? '' }}" id="title" name="title"
                                            class="form-control" type="text" placeholder="Tên bài viết">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Banner <span
                                                    class="text-danger">*</span></label>
                                            <img class="img-fluid img-thumbnail w-100" id="show_banner"
                                                style="cursor: pointer; height: 300px !important;"
                                                src="{{ showImage($journey->banner ?? '') }}" alt=""
                                                onclick="document.getElementById('banner').click();">
                                            <input type="file" name="banner" id="banner" class="form-control d-none"
                                                accept="image/*" onchange="previewImage(event, 'show_banner')">
                                        </div>
                                    </div>

                                    <div id="highlight-container">
                                        <!-- Phần Nổi bật mẫu -->
                                        @php
                                            $items =
                                                $journey && $journey->content
                                                    ? json_decode($journey->content, true)
                                                    : [];
                                        @endphp

                                        @forelse ($items as $index => $iten)
                                            <div class="row align-items-center mb-3 highlight-item">
                                                <div class="col-md-11">
                                                    <label class="form-label fw-bold highlight-label">Hành trình
                                                        {{ $index + 1 }}</label>
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-3">
                                                            <input type="text" name="name[]" class="form-control"
                                                                value="{{ $iten['name'] ?? '' }}"
                                                                placeholder="Nhập tiêu đề">
                                                        </div>

                                                        <div class="col-lg-12 mb-3">
                                                            <textarea name="content[]" class="form-control" rows="3" placeholder="Nhập mô tả">{{ $iten['content'] ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1 text-end">
                                                    <a class="btn btn-danger btn-sm w-100 mb-2 btn-remove"
                                                        style="display: none">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a class="btn btn-primary btn-sm w-100 btn-add">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="row align-items-center mb-3 highlight-item">
                                                <div class="col-md-11">
                                                    <label class="form-label fw-bold highlight-label">Hành trình 1</label>
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-3">
                                                            <input type="text" name="name[]" class="form-control"
                                                                placeholder="Nhập tiêu đề">
                                                        </div>

                                                        <div class="col-lg-12 mb-3">
                                                            <textarea name="content[]" class="form-control" rows="3" placeholder="Nhập mô tả"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1 text-end">
                                                    <a class="btn btn-danger btn-sm w-100 mb-2 btn-remove"
                                                        style="display: none">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a class="btn btn-primary btn-sm w-100 btn-add">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforelse

                                    </div>

                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/css/fontawesome-iconpicker.min.css">
    <style>
        .col-lg-9 .card {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border: 1px solid #eee;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/js/fontawesome-iconpicker.min.js">
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function initIconPicker() {
                $('.iconpicker-input').iconpicker({
                    placement: 'bottom',
                    animation: false,
                    search: true,
                    hideOnSelect: true,
                    inputSearch: true,
                }).on('iconpickerSelected', function(event) {
                    $(this).val(event.iconpickerValue);
                });

                $('.iconpicker-input').on('focus', function() {
                    $(this).iconpicker('show');
                });
            }

            function updateDeleteButtons() {
                const items = document.querySelectorAll(".highlight-item");
                document.querySelectorAll(".btn-remove").forEach(btn => {
                    btn.style.display = items.length > 1 ? "block" : "none";
                });
            }

            function updateLabels() {
                document.querySelectorAll(".highlight-label").forEach((label, index) => {
                    label.textContent = `Hành trình ${index + 1}`;
                });
            }

            const container = document.getElementById("highlight-container");
            container.addEventListener("click", function(event) {
                if (event.target.closest(".btn-add")) {
                    const highlightItem = event.target.closest(".highlight-item");
                    const newHighlight = highlightItem.cloneNode(true);

                    newHighlight.querySelectorAll("input, textarea, select").forEach(input => {
                        input.value = "";
                    });

                    highlightItem.insertAdjacentElement("afterend", newHighlight);
                    updateDeleteButtons();
                    updateLabels();
                    initIconPicker();
                }
            });

            container.addEventListener("click", function(event) {
                if (event.target.closest(".btn-remove")) {
                    event.target.closest(".highlight-item").remove();
                    updateDeleteButtons();
                    updateLabels();
                }
            });

            initIconPicker();
            updateDeleteButtons();
        });
    </script>
@endpush
