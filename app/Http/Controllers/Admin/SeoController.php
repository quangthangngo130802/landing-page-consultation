<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $config = Config::first() ?? [];
        return view('backend.config.seo', compact('config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
       

        $data['title_seo']    = $request->title_seo;
        $data['keyword_seo']      = $request->keyword_seo;
        $data['description_seo']    = $request->description_seo;

        $config = Config::first();

        Config::updateOrCreate(
            ['id' => optional($config)->id],
            $data
        );

        sessionFlash('success', 'Cập nhật thành công.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Config $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Config $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Config $config)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Config $config)
    {
        //
    }
}
