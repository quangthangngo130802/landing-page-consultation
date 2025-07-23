@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', [
        'page' => 'Kho khăn trong kinh doanh',
    ])

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" href="{{ route('admin.banners.index') }}">Banner</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" href="{{ route('admin.journey.index') }}">Tháo gỡ khó khăn</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active fw-bold">Khó khăn trong kinh doanh</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" href="{{ route('admin.configs.index') }}">Thông tin công ty</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" href="{{ route('admin.seo.index') }}">Seo</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-bold" id="seo-tab" href="">Cấu hình tư vẫn</a>
        </li>
    </ul>

    <form action="{{ route('admin.issues.store') }}" method="post" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active">
                                <div class="row">
                                    <div id="highlight-container" class="sortable-container">
                                        @php
                                            $issueList = old('name')
                                                ? collect(old('name'))->map(function ($name, $i) {
                                                    return ['id' => old('id')[$i] ?? '', 'name' => $name];
                                                })
                                                : $issues;
                                        @endphp

                                        @foreach ($issueList as $item)
                                            @php
                                                $id = is_array($item) ? $item['id'] ?? '' : $item->id ?? '';
                                                $name = is_array($item) ? $item['name'] ?? '' : $item->name ?? '';
                                            @endphp
                                            <div class="row align-items-center highlight-item mt-2">
                                                <div class="col-md-11 d-flex align-items-center gap-2">
                                                    <span class="drag-handle btn btn-light btn-xs" style="cursor: move;">
                                                        <i class="fas fa-arrows-alt"></i>
                                                    </span>
                                                    <input type="hidden" name="id[]" value="{{ $id }}">
                                                    <input type="text" name="name[]" value="{{ $name }}"
                                                        class="form-control" placeholder="Nhập khó khăn">
                                                </div>
                                                <div class="col-md-1 text-end">
                                                    <a class="btn btn-danger w-100 mb-2 btn-remove"
                                                        style="padding: 2px 6px; font-size: 0.75rem;">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a class="btn btn-primary w-100 btn-add"
                                                        style="padding: 2px 6px; font-size: 0.75rem;">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>


                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" id="btnSubmit" class="btn btn-primary">Lưu</button>
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
    <style>
        .btn-xs {
            padding: 2px 6px;
            font-size: 0.75rem;
            line-height: 1;
            border-radius: 0.2rem;
        }

        .sortable-container {
            max-height: 70vh;
            overflow-y: auto;
        }

        .highlight-item {
            background-color: #fff;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .sortable-ghost {
            opacity: 0.4;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/plugins/AutoScroll/Sortable.autoScroll.min.js"></script>

    <script>
        $(document).ready(function() {
            const $container = $('#highlight-container');
            const $form = $('#myForm');

            // SortableJS
            Sortable.create($container[0], {
                handle: ".drag-handle",
                animation: 150,
                ghostClass: "sortable-ghost",
                scroll: true,
                scrollSensitivity: 80,
                scrollSpeed: 20,
                forceFallback: true,
                fallbackTolerance: 5,
                onEnd: function() {
                    updateOrder(); // Gọi AJAX khi kéo xong
                }
            });

            function updateOrder() {
                let orderData = [];

                $("#highlight-container .highlight-item").each(function(index) {
                    const id = $(this).find('input[name="id[]"]').val();
                    if (id) {
                        orderData.push({
                            id: id,
                            location: index
                        });
                    }
                });

                $.ajax({
                    url: "{{ route('admin.issues.updateOrder') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order: orderData
                    },
                    success: function(res) {
                        console.log("Cập nhật vị trí thành công", res);
                    },
                    error: function(err) {
                        console.error("Lỗi cập nhật vị trí", err);
                    }
                });
            }


            function updateButtons() {
                const $items = $container.find('.highlight-item');
                $items.each(function(index) {
                    const $item = $(this);

                    $item.find('.btn-add').show();

                    $item.find('.btn-remove').toggle($items.length > 1);
                });
            }


            $container.on('click', '.btn-add, .btn-remove', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const $item = $btn.closest('.highlight-item');

                if ($btn.hasClass('btn-add')) {
                    const $clone = $item.clone();
                    $clone.find('input, textarea, select').val('');
                    $item.after($clone);
                    $clone.find('input').first().focus();
                    updateButtons();
                }

                if ($btn.hasClass('btn-remove')) {
                    $item.remove();
                    updateButtons();
                }
            });

            // Submit AJAX
            $('#btnSubmit').on('click', function(e) {
                e.preventDefault();

                const formData = new FormData($form[0]);

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#btnSubmit').prop('disabled', true).text('Đang lưu...');
                    },
                    success: function(res) {
                        alert('Lưu thành công!');
                        // hoặc window.location.href = '/duong-dan-moi';
                    },
                    error: function(xhr) {
                        alert('Đã có lỗi xảy ra!');
                        // Bạn có thể hiển thị lỗi chi tiết hơn ở đây
                        console.error(xhr.responseText);
                    },
                    complete: function() {
                        $('#btnSubmit').prop('disabled', false).text('Lưu');
                    }
                });
            });

            updateButtons();
        });
    </script>
@endpush
