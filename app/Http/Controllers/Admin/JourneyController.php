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

        // Lấy bản ghi Journey đầu tiên (để update hoặc xóa ảnh cũ)
        $journey = Journey::first();

        // Xử lý upload banner vào public/storage/journey
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $filename = time() . '_' . $image->getClientOriginalName();

            // Thư mục public/storage/journey
            $destinationPath = public_path('storage/journey');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Xóa ảnh cũ nếu có
            if (!empty($journey->banner) && file_exists(public_path('storage/' . $journey->banner))) {
                unlink(public_path('storage/' . $journey->banner));
            }

            // Lưu ảnh vào public/storage/journey
            $image->move($destinationPath, $filename);

            // Chỉ lưu tên thư mục và file (không có 'storage/')
            $data['banner'] = 'journey/' . $filename;
        }


        // Lưu tiêu đề
        $data['title'] = $request->title;

        // Lấy và định dạng lại dữ liệu name + content
        $json = $request->only(['name', 'content']);
        $formattedData = [];

        foreach ($json['name'] as $index => $name) {
            $formattedData[] = [
                'name' => $name,
                'content' => $json['content'][$index] ?? ''
            ];
        }

        $data['content'] = json_encode($formattedData, JSON_UNESCAPED_UNICODE);

        // Update hoặc tạo mới Journey
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
