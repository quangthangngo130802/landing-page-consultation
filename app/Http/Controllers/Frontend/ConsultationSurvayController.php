<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Mail\ConsultationSurvay;
use App\Models\ConsultationSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConsultationSurvayController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:50',
            'position' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:100',
            'business_field' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'challenges' => 'nullable|array', // checkbox có thể là mảng
            'other_challenge' => 'nullable|string',
            'biggest_challenge' => 'nullable|string',
        ]);

        ConsultationSurvey::create($data);

        $emailData = config('mail.to');

        // Gửi email thông báo
        Mail::to($emailData)->queue(new ConsultationSurvay($data));

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi yêu cầu tư vấn dịch vụ thành công!',
        ]);
    }
}