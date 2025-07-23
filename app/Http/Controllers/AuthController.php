<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use App\Services\TemplateService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Contact;
use App\Models\Province;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function login()
    {
        return view('backend.auth.login');
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->only(['email', 'password']);

        $remember = $request->boolean('remember');

        if (auth()->guard('admin')->attempt($credentials, $remember)) {


            $account = auth()->guard('admin')->user();


            if ($account->role_id != 1) {
                sessionFlash('error', 'Tài khoản không có quyền truy cập!');

                auth()->guard('admin')->logout();
                return back();
            }

            sessionFlash('success', 'Đăng nhập thành công.');
            return redirect()->route('admin.dashboard');
        } else {
            sessionFlash('error', 'Tài khoản hoặc mật khẩu không chính xác!');
            return back()->withInput();
        }
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        sessionFlash('success', 'Đăng xuất thành công.');
        return redirect()->route('admin.login');
    }


    public function loginUser()
    {
        return view('frontend.auth.login');
    }

    // public function registerUser()
    // {
    //     $city = Province::get();
    //     $contacts = Contact::get();
    //     return view('frontend.auth.register', compact('city', 'contacts'));
    // }

    // public function registerUserSubmit(RegisterRequest $request){

    //     $apiUrl  = config('app.api_url') .'/user/create';
    //     $apiUrl1 = config('app.api_url') .'/service/create';
    //     $apiUrl2 = config('app.api_url1') .'/user/store';

    //     $data = [
    //         'name' => $request->fullname,
    //         'email' => $request->email,
    //         'username' => $request->username,
    //         'phone' => $request->phone,
    //         'province' => $request->province,
    //         'password' => bcrypt($request->password),
    //         'status' => 'active',
    //         'hotel_homestay' => $request->hotel_homestay ?? ''
    //     ];

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . env('API_TOKEN'),
    //     ])->post($apiUrl, $data);

    //     $result = $response->json();
    //     if($result['success'] == true){
    //         $data['role_id'] = 2;

    //         $data['domain'] = null;
    //         $data['active_at'] = Carbon::now()->format('Y-m-d H:i:s');
    //         $data['number'] = 1;
    //         $data['is_hotel_account'] = 1;

    //         $response1 = Http::withHeaders([
    //             'Authorization' =>'Bearer ' . env('API_TOKEN'),
    //         ])->post($apiUrl1, $data);


    //         $response2 = Http::post($apiUrl2, $data);
    //         // if($response2['success'] == true){{
    //             $data['password'] = $request->password;
    //             // Mail::to($request->email)->queue(new WelcomeMail($data));
    //         //  }}
    //         $result = $this->templateService->zns($data);
    //         // sessionFlash('success', 'Đăng ký thành công!');
    //         return view('frontend.success.index', compact('data'));
    //     }else{
    //         sessionFlash('error', $result['message']);
    //         return back()->withInput();
    //     }

    // }


    // public function authenticateUser(Request $request)
    // {

    //     $credentials = $request->only(['email', 'password']);

    //     $remember = $request->boolean('remember');

    //     if (auth()->attempt($credentials, $remember)) {


    //         $account = auth()->user();


    //         if ($account->role_id != 2) {
    //             sessionFlash('error', 'Tài khoản không có quyền truy cập!');

    //             auth()->logout();
    //             return back();
    //         }

    //         sessionFlash('success', 'Đăng nhập thành công.');
    //         return redirect()->route('home');
    //     } else {
    //         sessionFlash('error', 'Tài khoản hoặc mật khẩu không chính xác!');
    //         return back()->withInput();
    //     }
    // }

}
