<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // IssueController.php
    public function index()
    {
        $issues = Issue::orderBy('location')->get(); // sắp xếp theo vị trí
        return view('backend.config.issue', compact('issues'));
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
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'nullable|string|max:255',
            'id' => 'nullable|array',
            'id.*' => 'nullable|integer',
        ]);

        $names = $request->input('name', []);
        $ids = $request->input('id', []);

        $submittedIds = [];

        foreach ($names as $index => $name) {
            if (!$name) continue;

            $id = $ids[$index] ?? null;
            $location = $index; // thứ tự xuất hiện trong form

            if ($id) {
                Issue::where('id', $id)->update([
                    'name' => $name,
                    'location' => $location,
                ]);
                $submittedIds[] = $id;
            } else {
                $new = Issue::create([
                    'name' => $name,
                    'location' => $location,
                ]);
                $submittedIds[] = $new->id;
            }
        }

        // Xóa các bản ghi không có trong form
        if (!empty($submittedIds)) {
            Issue::whereNotIn('id', $submittedIds)->delete();
        } else {
            Issue::truncate();
        }

        return response()->json(['success' => true]);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $item) {
            if (!empty($item['id'])) {
                Issue::where('id', $item['id'])->update(['location' => $item['location']]);
            }
        }

        return response()->json(['success' => true]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
