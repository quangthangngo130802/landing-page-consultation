<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin đăng ký tư vấn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            line-height: 1.5;
            padding: 20px;
        }

        .email-wrapper {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
        }

        h2 {
            color: #dc3545;
            font-size: 22px;
            margin-bottom: 25px;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            color: #343a40;
        }

        .info-value {
            margin-left: 5px;
            color: #495057;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #6c757d;
            text-align: center;
        }

        .challenges-list {
            padding-left: 20px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <h2>📋 Thông tin đăng ký tư vấn từ website</h2>

        <div class="info-group">
            <span class="info-label">👤 Họ và tên:</span>
            <span class="info-value">{{ $data['full_name'] }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">📧 Email:</span>
            <span class="info-value">{{ $data['email'] }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">📱 Số điện thoại:</span>
            <span class="info-value">{{ $data['phone'] }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">💼 Chức danh:</span>
            <span class="info-value">{{ $data['position'] ?? '—' }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">🌍 Khu vực:</span>
            <span class="info-value">{{ $data['region'] ?? '—' }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">🏢 Lĩnh vực hoạt động:</span>
            <span class="info-value">{{ $data['business_field'] ?? '—' }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">🧾 Mã số thuế/Công ty:</span>
            <span class="info-value">{{ $data['tax_id'] ?? '—' }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">⚠️ Các khó khăn doanh nghiệp đang gặp:</span>
            @if(!empty($data['challenges']) && is_array($data['challenges']))
                <ul class="challenges-list">
                    @foreach($data['challenges'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <span class="info-value">—</span>
            @endif
        </div>

        <div class="info-group">
            <span class="info-label">✏️ Khó khăn khác:</span>
            <span class="info-value">{{ $data['other_challenge'] ?? '—' }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">🔥 Khó khăn lớn nhất hiện tại:</span>
            <span class="info-value">{{ $data['biggest_challenge'] ?? '—' }}</span>
        </div>

       
    </div>
</body>
</html>
