<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Journey;
use App\Services\BaseQuery;
use Illuminate\Http\Request;


class JourneyController extends Controller
{
    public function index()
    {
        //
        $journey = Journey::first();
        // dd($highlights);

        return view('backend.config.journey', compact('journey'));
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

        $data = [];

        if ($request->hasFile('banner')) {
            $data['banner'] = saveImages($request, 'banner', 'journey');
        }

        $data['title'] = $request->title;

        $json = $request->only(['name', 'content']);

        // Định dạng lại dữ liệu
        $formattedData = [];

        foreach ($json['name'] as $index => $name) {
            $formattedData[] = [
                'name' => $name,
                'content' => $json['content'][$index] ?? ''
            ];
        }

        $data['content'] = json_encode($formattedData, JSON_UNESCAPED_UNICODE);

        $journey = Journey::first();

        Journey::updateOrCreate(
            ['id' => optional($journey)->id],
            $data
        );

        sessionFlash('success', 'Cập nhật thành công.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Journey $journey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journey $journey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journey $journey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journey $journey)
    {
        //
    }
}
