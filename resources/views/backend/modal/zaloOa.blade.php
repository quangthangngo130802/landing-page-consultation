<div class="modal fade" id="oazaloModal" tabindex="-1" aria-labelledby="oazaloModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="add-oa-form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="oazaloModalLabel">OA Zalo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label for="name">Tên OA</label>
                        <input type="text" class="form-control" id="name_oa" value="{{ $zaloOa->name_oa ?? '' }}"
                            name="name_oa">
                        <div class="invalid-feedback" id="name_oa-error" style="display: none;"></div>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="oa_id">OA ID</label>
                        <input type="text" class="form-control" id="oa_id" name="oa_id"
                            value="{{ $zaloOa->oa_id ?? '' }}">
                        <div class="invalid-feedback" id="oa_id-error" style="display: none;"></div>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="access_token">Access Token</label>
                        <textarea class="form-control" id="access_token" name="access_token">{{ $zaloOa->access_token ?? '' }}</textarea>

                        <div class="invalid-feedback" id="access_token-error" style="display: none;"></div>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="refresh_token">Refresh Token</label>
                        <textarea class="form-control" id="refresh_token" name="refresh_token">{{ $zaloOa->refresh_token ?? '' }}</textarea>
                        <div class="invalid-feedback" id="refresh_token-error" style="display: none;"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" form="add-oa-form">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="loading-overlay"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); color:white; font-size:24px;">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <div style="margin-right: 30px !important">Loading...</div>

    </div>
</div>

@push('styles')
    <style>
        #loading-overlay {
            display: none;
            align-items: center;
            justify-content: center;

        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#add-oa-form").submit(function(event) {
                event.preventDefault();

                let isValid = true;
                let fields = ["name_oa", "oa_id", "access_token", "refresh_token"];
                $.each(fields, function(index, field) {
                    $("#" + field + "-error").hide().text("");
                    $("#" + field).removeClass("is-invalid");
                });

                if ($.trim($("#name_oa").val()) === "") {
                    $("#name_oa-error").text("Tên OA không được để trống.").show();
                    $("#name_oa").addClass("is-invalid");
                    isValid = false;
                }
                if ($.trim($("#oa_id").val()) === "") {
                    $("#oa_id-error").text("OA ID không được để trống.").show();
                    $("#oa_id").addClass("is-invalid");
                    isValid = false;
                }
                if ($.trim($("#access_token").val()) === "") {
                    $("#access_token-error").text("Access Token không được để trống.").show();
                    $("#access_token").addClass("is-invalid");
                    isValid = false;
                }
                if ($.trim($("#refresh_token").val()) === "") {
                    $("#refresh_token-error").text("Refresh Token không được để trống.").show();
                    $("#refresh_token").addClass("is-invalid");
                    isValid = false;
                }

                if (isValid) {
                    // Hiển thị overlay loading
                    $("#loading-overlay").show();

                    let formData = new FormData(this);
                    $.ajax({
                        url: "/admin/zaloOa/update",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            $("#loading-overlay").hide(); // Tắt overlay

                            if (res.success) {
                                Toast.fire({
                                    icon: "success",
                                    title: res.message,
                                });

                                let modalEl = $('#oazaloModal')[0];
                                let modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) modal.hide();

                                if (window.location.pathname == '/admin/zaloOa/message') {
                                    window.location.reload();
                                }
                            }
                        },
                        error: function(xhr) {
                            $("#loading-overlay").hide(); // Tắt overlay

                            Toast.fire({
                                icon: "error",
                                title: xhr.responseJSON?.message || "Đã có lỗi xảy ra!",
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
