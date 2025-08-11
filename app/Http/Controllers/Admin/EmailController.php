<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class EmailController extends Controller
{
    public function updateMailEnv(Request $request)
    {
        $email = $request->email;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'Email không hợp lệ!']);
        }

        $envPath = base_path('.env');
        $key = 'MAIL_TO';

        if (file_exists($envPath)) {
            // Ghi lại vào file .env
            file_put_contents($envPath, preg_replace(
                "/^{$key}=.*$/m",
                "{$key}={$email}",
                file_get_contents($envPath)
            ));

            // Cập nhật config runtime nếu cần
            config(['mail.mail_to' => $email]);

            return response()->json(['message' => 'Cập nhật email thành công']);
        }

        return response()->json(['message' => 'Không tìm thấy file .env'], 500);
    }
}