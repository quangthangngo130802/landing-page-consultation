<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Journey;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        $customers = Customer::all();
        $journeys = Journey::all();

        // Giả sử bạn chỉ lấy journey đầu tiên để hiển thị
        $journey = $journeys->first();

        // Decode content thành array
        $journey->content = json_decode($journey->content, true);
        return view('frontend.layouts.app', compact('customers', 'journey'));
    }

}