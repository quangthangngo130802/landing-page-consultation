@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => isset($post) ? 'Sửa bài viết' : 'Thêm bài viết',
        'href' => route('admin.posts.index'),
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active fw-bold" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                aria-controls="info" aria-selected="true">Thông Tin Sản Phẩm</a>
        </li>
    </ul>

    @php
        $action = isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store');
    @endphp

    <form action="{{ $action }}" method="post" enctype="multipart/form-data" id="myForm">
        {{-- @csrf --}}
        @isset($post)
            @method('PUT')
        @endisset
        {{-- @csrf --}}
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel"
                                aria-labelledby="info-tab">
                                <div class="row">
                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="name" class="form-label">Tên bài viết<span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $post->title ?? '' }}" oninput="convertSlug('#title', '#slug')"
                                            id="title" name="title" class="form-control" type="text"
                                            placeholder="Tên bài viết">
                                    </div>

                                    <div class="form-group mb-3 col-lg-6">
                                        <label for="slug" class="form-label">Đường dẫn thân thiện</label>
                                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Không nhập sẽ lấy theo tên"></i>
                                        <input id="slug" value="{{ $post->slug ?? '' }}" name="slug"
                                            class="form-control" type="text" placeholder="Đường dẫn thân thiện">
                                    </div>

                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="name" class="form-label">Địa chỉ<span
                                                class="text-danger"></span></label>
                                        <input value="{{ $post->address ?? '' }}" id="address" name="address"
                                            class="form-control" type="text" placeholder="Địa chỉ">
                                    </div>


                                    <div class="form-group mb-3 col-lg-12">
                                        <label for="slug" class="form-label">Mô tả chi tiết</label>
                                        <textarea name="description" class="form-control ckeditor" id="description" placeholder="Mô tả ">{!! $post->description ?? '' !!}</textarea>
                                    </div>

                                    {{-- Điểm SEO --}}
                                    @php

                                        $seoScoreValue = $seoData['seoScoreValue'] ?? 0;
                                        $analysis = $seoData['analysis'] ?? [];
                                        $hasWarning = $seoData['hasWarning'] ?? false;

                                        $seoColor = 'bg-danger'; // đỏ mặc định (dưới 50)
                                        $badgeClass = 'bg-danger';

                                        if ($seoScoreValue >= 80) {
                                            $seoColor = 'bg-success'; // xanh lá (tốt)
                                            $badgeClass = 'bg-success';
                                        } elseif ($seoScoreValue >= 50) {
                                            $seoColor = 'bg-warning'; // vàng (trung bình)
                                            $badgeClass = 'bg-warning text-dark';
                                        }
                                    @endphp

                                    <div class="form-group mb-3 mt-3 col-lg-12">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0">Điểm SEO tổng thể</h5>
                                                <span class="badge {{ $badgeClass }} fs-6" id="seo-score-badge">
                                                    {{ $seoScoreValue }}/100
                                                </span>
                                            </div>
                                            <div class="progress mb-3" style="height: 10px;">
                                                <div class="progress-bar {{ $seoColor }}" id="seo-score-progress"
                                                    role="progressbar" style="width: {{ $seoScoreValue }}%;"
                                                    aria-valuenow="{{ $seoScoreValue }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- List SEO --}}
                                    <div class="" id="result">
                                        @include('backend.post.seo', ['seoData' => $seoData])
                                    </div>

                                    <!-- Google Snippet Preview -->
                                    <div class="form-group mb-3 mt-3 col-lg-12">
                                        <label class="form-label fw-semibold">Preview trên Google</label>
                                        <div id="google-snippet-preview"
                                            style="background:#fff;border:1px solid #e0e0e0;padding:16px 20px;border-radius:8px;max-width:700px;">
                                            <div id="gsp-title"
                                                style="color:#1a0dab;font-size:20px;line-height:1.2;font-weight:400;margin-bottom:2px;">
                                                {{ old('title_seo', $post->title_seo ?? 'Tiêu đề bài viết') }}</div>
                                            <div id="gsp-url"
                                                style="color:#006621;font-size:14px;line-height:1.3;margin-bottom:2px;">
                                                {{ url('/post') }}/<span
                                                    id="gsp-slug">{{ old('slug', $post->slug ?? 'slug-bai-viet') }}</span>
                                            </div>
                                            <div id="gsp-desc" style="color:#545454;font-size:13px;line-height:1.4;">
                                                {{ old('description_seo', $post->description_seo ?? 'Mô tả ngắn của bài viết sẽ hiển thị ở đây.') }}
                                            </div>
                                        </div>
                                    </div>


                                    {{-- SEO --}}
                                    <div class="form-group mb-3 mt-3">
                                        <label for="title_seo" class="form-label">Tiêu đề seo</label>
                                        <input type="text" value="{{ $post->title_seo ?? '' }}"
                                            placeholder="Tiêu đề seo" id="title_seo" name="title_seo"
                                            class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="description_seo" class="form-label">Mô tả seo</label>
                                        <textarea name="description_seo" id="description_seo" cols="30" rows="4" class="form-control"
                                            placeholder="Mô tả seo">{{ $post->description_seo ?? '' }}</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="keyword_seo" class="form-label">Từ khóa seo</label>
                                        <input id="keyword_seo" value="{{ $post->keyword_seo ?? '' }}"
                                            name="keyword_seo">
                                    </div>

                                    {{-- <div class="form-group mb-3">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input id="tags" class="form-control" value="{{ $post->tags ?? '' }}"
                                            name="tags">
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Trạng thái</h5>
                    </div>

                    <div class="card-body">
                        <select name="status" id="status" class="form-select">
                            <option value="1" @selected(($post->status ?? 1) == 1)>Xuất bản</option>
                            <option value="2" @selected(($post->status ?? 2) == 2)>Chưa xuất bản</option>
                        </select>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Loại bài viết</h5>
                    </div>

                    <div class="card-body">
                        <select name="type" id="type" class="form-select">
                            <option value="post" @selected(($post->type ?? 'post') == 'post')>Tin tức</option>
                            <option value="customer" @selected(($post->type ?? '') == 'customer')>Khách hàng</option>
                        </select>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ảnh </h5>
                    </div>

                    <div class="card-body">
                        <img class="img-fluid img-thumbnail w-100" id="show_image" style="cursor: pointer; "
                            src="{{ showImage($post->image ?? '') }}" alt=""
                            onclick="document.getElementById('image').click();">
                        <input type="file" name="image" id="image" class="form-control d-none"
                            accept="image/*" onchange="previewImage(event, 'show_image')">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button id="submitBtn" class="btn btn-primary btn-sm d-flex align-items-center gap-2" type="submit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fas fa-save me-1"></i> Lưu
                    </button>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">
    <style>
        .col-lg-9 .card {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border: 1px solid #eee;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('backend/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/tagify.min.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>

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

            ckeditor('description')

            submitForm('#myForm', function(response) {
                window.location.href = "{{ route('admin.posts.index') }}"
            });


            $('.input-images').imageUploader({
                preloaded: preloaded, // Ảnh đã có sẵn
                imagesInputName: 'images', // Tên input khi upload ảnh mới
                preloadedInputName: 'old', // Tên input chứa ảnh cũ
                maxSize: 2 * 1024 * 1024, // Giới hạn ảnh 2MB
                maxFiles: 15, // Tối đa 15 ảnh
            });

            // formatDataInput('price');
        });
    </script>

    <script>
        $(document).ready(function() {
            function updateSnippetPreview() {
                let seoTitle = $('#title_seo').val() || 'Tiêu đề bài viết';
                let slug = seoTitle
                let seoDescription = $('#description_seo').val() || 'Mô tả ngắn của bài viết sẽ hiển thị ở đây.';

                $('#gsp-title').text(seoTitle);
                $('#gsp-slug').text(slug);
                $('#gsp-desc').text(seoDescription);
            }

            $('#title_seo, #slug, #description_seo').on('input', updateSnippetPreview);
            updateSnippetPreview(); 
        });
    </script>


    {{-- Xử lí khi thêm mới bài viết --}}
    <script>
        let seoTimeout;

        // Định nghĩa hàm trước
        function runSeoAnalysis() {
            const description = CKEDITOR.instances['description']?.getData() || '';

            const rawKeywords = $('#keyword_seo').val();
            let keyword_seo = [];

            try {
                const parsed = JSON.parse(rawKeywords);
                if (Array.isArray(parsed)) {
                    keyword_seo = parsed.map(k => k.value?.trim()).filter(Boolean);
                }
            } catch (e) {
                keyword_seo = (rawKeywords || '').split(',').map(k => k.trim()).filter(Boolean);
            }

            const title_seo = $('#title_seo').val();
            const hasKeyword = keyword_seo.some(keyword => title_seo.toLowerCase().includes(keyword.toLowerCase()));
            const description_seo = $('#description_seo').val();
            const slug = $('#slug').val();

            const data = {
                description,
                keyword_seo,
                title_seo,
                hasKeyword,
                description_seo,
                slug,
                _token: '{{ csrf_token() }}'
            };

            console.log('⏳ Gửi dữ liệu SEO:', data);

            $.ajax({
                url: "{{ route('admin.posts.seo.analysis.live') }}",
                method: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#seo-score-badge').removeClass().addClass(`badge ${response.badgeClass} fs-6`).text(
                            response.seoScoreVal + '/100');
                        $('#seo-score-progress').removeClass().addClass(`progress-bar ${response.seoColor}`)
                            .css('width', response.seoScoreVal + '%');
                        $('#result').html(response.html);
                    }
                    console.log('✅ Phản hồi SEO:', response);
                },
                error: function(xhr) {
                    console.error('❌ Lỗi SEO:', xhr);
                }
            });
        }

        // Chờ document sẵn sàng
        $(document).ready(function() {
            // Các input thông thường
            $('#title_seo, #keyword_seo, #description_seo, #slug').on('input', function() {
                clearTimeout(seoTimeout);
                seoTimeout = setTimeout(runSeoAnalysis, 500);
            });

            // CKEditor ready
            CKEDITOR.on('instanceReady', function(evt) {
                evt.editor.on('change', function() {
                    clearTimeout(seoTimeout);
                    seoTimeout = setTimeout(runSeoAnalysis, 500);
                });

                // Nếu là trang chỉnh sửa thì gọi luôn
                @if (isset($post))
                    setTimeout(runSeoAnalysis, 500);
                @endif
            });
        });
    </script>
@endpush
