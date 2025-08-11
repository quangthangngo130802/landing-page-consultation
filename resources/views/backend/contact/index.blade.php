@extends('backend.layouts.master')

@section('title', 'Danh sách cần tư vấn')
@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Danh sách cần tư vấn</h4>
            <input type="text" class="form-control w-25" name=email value="{{ config('mail.to') }}" id="mailInput">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">
                    
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll" /></th>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Chức vụ</th>
                            <th>Địa chỉ</th>
                            <th>Khó khăn</th>
                            <th>Thời gian</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.16.1/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.16.1/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            const api = '{{ route('admin.contacts.index') }}'

            const columns = [{
                    data: "checkbox",
                    name: "checkbox",
                    orderable: false,
                    searchable: false,
                    className: "text-center"
                },
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'position',
                    name: 'position'
                },
                {
                    data: 'region',
                    name: 'region'
                },
                {
                    data: 'biggest_challenge',
                    name: 'biggest_challenge'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    className: "text-center"
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    className: "text-center"
                },
            ];


            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: api,
                columns: columns
            });

            // Nếu muốn khi bỏ chọn 1 checkbox con thì checkbox tổng cũng bỏ chọn
            $('#myTable').on('change', '.select-item', function() {
                const all = $('#myTable .select-item').length;
                const checked = $('#myTable .select-item:checked').length;
                $('#selectAll').prop('checked', all === checked);
            });

        });

        document.getElementById('mailInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const email = this.value;

                fetch('{{ route('admin.update-mail-env') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            email
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(err => console.error('Lỗi:', err));
            }
        });
    </script>
    <script>
        function handleDestroy(modelName) {
            // Lắng nghe sự kiện click nút xóa
            $('.btn-delete').off('click').on('click', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Bạn chắc chắn muốn xóa?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/contacts/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                $('#myTable').DataTable().ajax.reload();
                                Swal.fire('Đã xóa!', res.message || 'Đã xóa thành công.',
                                    'success');
                            },
                            error: function(xhr) {
                                Swal.fire('Lỗi!', xhr.responseJSON?.message || 'Không thể xóa.',
                                    'error');
                            }
                        });
                    }
                });
            });
        }
    </script>
@endpush
