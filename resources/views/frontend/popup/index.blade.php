<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .sgo-modal {
        max-width: 1000px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 2px solid #000;
    }

    .sgo-modal .modal-content {
        border: none;
        border-radius: 20px;
    }

    .left-section {

        padding: 60px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        min-height: 700px;
    }

    .sgo-logo {
        width: 90px;
        height: 90px;
        background: #dc3545;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        position: relative;
    }

    .sgo-logo::before {
        content: 'S';
        color: white;
        font-size: 36px;
        font-weight: bold;
        position: absolute;
        left: 15px;
    }

    .sgo-logo::after {
        content: '';
        width: 0;
        height: 0;
        border-left: 20px solid #333;
        border-top: 12px solid transparent;
        border-bottom: 12px solid transparent;
        position: absolute;
        right: 15px;
    }

    .brand-text {
        color: #333;
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 5px;
    }

    .tagline {
        color: #6c757d;
        font-size: 12px;
        margin-bottom: 40px;
        letter-spacing: 2px;
    }

    .main-text {
        color: #dc3545;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
        line-height: 1.4;
    }

    .sub-text {
        color: #333;
        font-size: 14px;
        line-height: 1.4;
    }

    .right-section {
        padding: 50px 45px;
        background: white;
    }

    .form-title {
        color: #dc3545;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 40px;
        line-height: 1.3;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        color: #333;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
    }

    .form-control,
    .form-select {
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 15px 18px;
        font-size: 14px;
        width: 100%;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        outline: none;
        background: white;
    }

    .form-control::placeholder {
        color: #adb5bd;
        font-size: 14px;
    }

    .btn-submit {
        background-color: #dc3545;
        border: none;
        border-radius: 25px;
        padding: 8px 30px;
        font-size: 15px;
        font-weight: bold;
        color: white;
        float: right;
        margin-top: 30px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        position: relative;
    }

    .btn-submit:hover {
        background-color: #c82333;
        color: white;
        transform: translateY(-2px);
    }

    .btn-submit:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
    }

    .btn-submit::after {
        content: '→';
        margin-left: 8px;
        font-size: 16px;
    }

    .modal-header {
        border: none;
        padding: 20px 25px 0;
    }

    .btn-close {
        font-size: 14px;
    }

    .business-field-note {
        color: #6c757d;
        font-size: 13px;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .sgo-modal {
            max-width: 95%;
            margin: 10px;
        }

        .left-section {
            min-height: auto;
            padding: 40px 25px;
        }

        .right-section {
            padding: 40px 30px;
        }

        .form-title {
            font-size: 20px;
        }

        .main-text {
            font-size: 20px;
        }
    }

    .form-slider-wrapper {
        position: relative;
        width: 100%;
        min-height: 500px;
        overflow: hidden;
    }

    .form-step {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        transition: transform 0.5s cubic-bezier(.77, 0, .18, 1), opacity 0.5s;
        opacity: 0;
        z-index: 1;
        background: #fff;
    }

    .form-step.active {
        transform: translateX(0);
        opacity: 1;
        z-index: 2;
        position: relative;
    }

    .form-step.to-left {
        transform: translateX(-100%);
        opacity: 0;
        z-index: 1;
    }

    .form-step.from-right {
        transform: translateX(100%);
        opacity: 0;
        z-index: 1;
    }

    .btn-back {
        background-color: #6c757d;
        /* Màu xám */
        border: none;
        border-radius: 25px;
        padding: 8px 30px;
        font-size: 15px;
        font-weight: bold;
        color: white;
        margin-top: 30px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        position: relative;
    }

    .btn-back:hover {
        background-color: #5a6268;
        color: white;
        transform: translateY(-2px);
    }

    .btn-back::before {
        content: '←';
        margin-right: 8px;
        font-size: 16px;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="sgoModal" tabindex="-1" aria-labelledby="sgoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl sgo-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Left Section -->
                    <div class="col-lg-5">
                        <div class="left-section">
                            <div class="sgo-logo"></div>
                            <div class="brand-text">SGO VIỆT NAM</div>
                            <div class="tagline">FAST MOVING</div>
                            <div class="main-text">
                                Cùng SGO thấu hiểu khó khăn<br>
                                của doanh nghiệp bạn
                            </div>
                            <div class="sub-text">
                                Đồng hành phát triển bền vững trong kỷ nguyên số
                            </div>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="col-lg-7">
                        <div class="right-section">
                            <div class="form-slider-wrapper" style="min-height: 600px;">
                                <!-- Form 1 -->
                                <div class="form-step active" id="formStep1">
                                    <h5 class="form-title">
                                        Đăng ký tư vấn ngay<br>
                                        để nhận quà tặng hấp dẫn
                                    </h5>
                                    <form id="consultationForm">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label">Họ và tên <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="full_name"
                                                placeholder="Nhập họ và tên của bạn" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Nhập email của bạn" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Số điện thoại <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" name="phone"
                                                placeholder="Nhập số điện thoại liên hệ của bạn" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Chức danh</label>
                                            <input type="text" class="form-control" name="position"
                                                placeholder="Chọn chức danh của bạn">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Khu vực</label>
                                            <select class="form-select" name="region">
                                                <option value="">Chọn khu vực của bạn</option>
                                                <option value="Hà Nội">Hà Nội</option>
                                                <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                                                <option value="Đà Nẵng">Đà Nẵng</option>
                                                <option value="Hải Phòng">Hải Phòng</option>
                                                <option value="Cần Thơ">Cần Thơ</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Lĩnh vực hoạt động <span
                                                    class="business-field-note">(Chọn và ghi rõ)</span></label>
                                            <select class="form-select" name="business_field">
                                                <option value="">Chọn và ghi rõ ngành nghề của bạn</option>
                                                <option value="Công nghệ thông tin">Công nghệ thông tin</option>
                                                <option value="Sản xuất">Sản xuất</option>
                                                <option value="Bán lẻ">Bán lẻ</option>
                                                <option value="Tài chính - Ngân hàng">Tài chính - Ngân hàng</option>
                                                <option value="Y tế - Sức khỏe">Y tế - Sức khỏe</option>
                                                <option value="Giáo dục">Giáo dục</option>
                                                <option value="Bất động sản">Bất động sản</option>
                                                <option value="Bất động sản">Bất động sản</option>
                                                <option value="Thực phẩm - Đồ uống">Thực phẩm - Đồ uống</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Mã số thuế/Công ty</label>
                                            <input type="text" class="form-control" name="tax_id"
                                                placeholder="Nhập mã số thuế/ công ty của bạn">
                                        </div>
                                        <button type="button" class="btn btn-submit" id="btnNext">
                                            Tiếp
                                        </button>
                                    </form>
                                </div>
                                <!-- Form 2 -->
                                <div class="form-step from-right" id="formStep2">
                                    <h5 class="form-title">
                                        Đăng ký tư vấn ngay<br>
                                        để nhận quà tặng hấp dẫn
                                    </h5>
                                    <form id="surveyForm">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label" style="font-weight: bold;">
                                                Doanh nghiệp bạn đang gặp khó khăn chủ yếu ở khâu nào?
                                                <span style="font-weight: normal; font-style: italic;">(Chọn tối đa 3
                                                    mục)</span>
                                            </label>
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="challenges"
                                                        value="Thiếu vốn/tài chính" id="challenge1">
                                                    <label class="form-check-label" for="challenge1">Thiếu vốn/tài
                                                        chính</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="challenges"
                                                        value="Khó khăn trong việc tìm kiếm khách hàng mới"
                                                        id="challenge2">
                                                    <label class="form-check-label" for="challenge2">Khó khăn trong
                                                        việc tìm kiếm khách hàng mới</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="challenges"
                                                        value="Chi phí marketing cao, hiệu quả thấp" id="challenge3">
                                                    <label class="form-check-label" for="challenge3">Chi phí marketing
                                                        cao, hiệu quả thấp</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="challenges"
                                                        value="Bán hàng kém hiệu quả" id="challenge4">
                                                    <label class="form-check-label" for="challenge4">Bán hàng kém hiệu
                                                        quả</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="challenges"
                                                        value="Thiếu nhân sự chất lượng" id="challenge5">
                                                    <label class="form-check-label" for="challenge5">Thiếu nhân sự
                                                        chất lượng</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="challenges"
                                                        value="Quy trình vận hành chưa tối ưu" id="challenge6">
                                                    <label class="form-check-label" for="challenge6">Quy trình vận
                                                        hành chưa tối ưu (Quản trị khách hàng, ứng dụng công nghệ chưa
                                                        hiệu quả...)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="challenges"
                                                        value="Khác" id="challenge7">
                                                    <label class="form-check-label" for="challenge7">Khác:</label>
                                                    <input type="text" class="form-control mt-2"
                                                        name="other_challenge" placeholder="Nhập khó khăn khác">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" style="font-weight: bold;">
                                                Đâu là khó khăn lớn nhất của bạn hiện tại? <span
                                                    class="text-danger">*</span>
                                                <span style="font-weight: normal; font-style: italic;">(Mô tả ngắn
                                                    gọn)</span>
                                            </label>
                                            <textarea class="form-control" name="biggest_challenge" rows="2"
                                                placeholder="→ __________________________________________________________"></textarea>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-back" id="btnBack">Quay
                                                lại</button>
                                            <button type="submit" class="btn btn-submit"
                                                id="btnSubmitSurvey">Gửi</button>
                                        </div>

                                    </form>
                                </div>
                            </div> <!-- end form-slider-wrapper -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Slide effect
        const formStep1 = document.getElementById('formStep1');
        const formStep2 = document.getElementById('formStep2');
        const btnNext = document.getElementById('btnNext');
        const btnBack = document.getElementById('btnBack');

        // Next to Form 2
        btnNext.addEventListener('click', function(e) {
            e.preventDefault();
            // Validate Form 1
            const form = document.getElementById('consultationForm');
            const fullName = form.full_name.value.trim();
            const email = form.email.value.trim();
            const phone = form.phone.value.trim();

            // if (!full_name) {
            //     alert('Vui lòng nhập họ và tên!');
            //     return;
            // }
            // if (!email) {
            //     alert('Vui lòng nhập email!');
            //     return;
            // }
            // if (!isValidEmail(email)) {
            //     alert('Vui lòng nhập email hợp lệ!');
            //     return;
            // }
            // if (!phone) {
            //     alert('Vui lòng nhập số điện thoại!');
            //     return;
            // }
            // if (!isValidPhone(phone)) {
            //     alert('Vui lòng nhập số điện thoại hợp lệ!');
            //     return;
            // }

            // Slide effect
            formStep1.classList.remove('active');
            formStep1.classList.add('to-left');
            formStep2.classList.add('active');
            formStep2.classList.remove('from-right');
        });

        // Back to Form 1
        btnBack.addEventListener('click', function(e) {
            e.preventDefault();
            formStep2.classList.remove('active');
            formStep2.classList.add('from-right');
            formStep1.classList.add('active');
            formStep1.classList.remove('to-left');
        });

        // Survey Form validation & submit
        const surveyForm = document.getElementById('surveyForm');
        const btnSubmitSurvey = document.getElementById('btnSubmitSurvey');
        surveyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Validate: chọn tối đa 3 mục
            const checked = surveyForm.querySelectorAll('input[name="challenges"]:checked');
            if (checked.length === 0) {
                alert('Vui lòng chọn ít nhất 1 khó khăn!');
                return;
            }
            if (checked.length > 3) {
                alert('Chỉ được chọn tối đa 3 mục!');
                return;
            }
            const biggestChallenge = surveyForm.biggestChallenge.value.trim();
            if (!biggestChallenge) {
                alert('Vui lòng mô tả khó khăn lớn nhất!');
                return;
            }
        });

        // Email validation
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        // Phone validation (Vietnamese phone numbers)
        function isValidPhone(phone) {
            const phoneRegex = /^(0|\+84)[0-9]{9,10}$/;
            return phoneRegex.test(phone.replace(/\s/g, ''));
        }
        // Format phone number input
        const phoneInput = document.querySelector('input[name="phone"]');
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.startsWith('84')) {
                    value = '+' + value;
                } else if (!value.startsWith('0')) {
                    value = '0' + value;
                }
            }
            e.target.value = value;
        });

        // Limit checkbox selection to 3
        const challengeCheckboxes = surveyForm.querySelectorAll('input[name="challenges"]');
        challengeCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const checked = surveyForm.querySelectorAll('input[name="challenges"]:checked');
                if (checked.length > 3) {
                    this.checked = false;
                    alert('Chỉ được chọn tối đa 3 mục!');
                }
            });
        });

        // Khi đóng modal thì reset về form 1
        document.getElementById('sgoModal').addEventListener('hidden.bs.modal', function() {
            formStep2.classList.remove('active');
            formStep2.classList.add('from-right');
            formStep1.classList.add('active');
            formStep1.classList.remove('to-left');
            surveyForm.reset();
            document.getElementById('consultationForm').reset();
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    jQuery(function() {
        jQuery('#surveyForm').on('submit', function(e) {
            e.preventDefault(); // Ngăn reload trang

            const form1 = document.querySelector('#consultationForm');
            const form2 = document.querySelector('#surveyForm');
            const formData = new FormData();

            // Lấy dữ liệu từ cả 2 form
            [...form1.elements, ...form2.elements].forEach(el => {
                if (el.name) {
                    if (el.type === 'checkbox') {
                        if (el.checked) {
                            formData.append(el.name + '[]', el.value); // Checkbox dạng mảng
                        }
                    } else {
                        formData.append(el.name, el.value);
                    }
                }
            });

            jQuery.ajax({
                url: '/consultation', // Đường dẫn xử lý backend
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (response) => {
                    form1.reset();
                    form2.reset();
                    jQuery('#sgoModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Gửi thành công!',
                        text: response.message ||
                            'Chúng tôi đã nhận thông tin của bạn.',
                        confirmButtonText: 'OK'
                    });
                },
                error: (xhr) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại!',
                        text: xhr.responseJSON?.message ||
                            'Có lỗi xảy ra. Vui lòng thử lại!',
                    });
                }
            });
        });
    });
</script>
