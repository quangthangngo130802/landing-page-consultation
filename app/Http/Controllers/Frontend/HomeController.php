<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Logic to retrieve data for the homepage can be added here
        return view('frontend.layouts.app');
    }

}