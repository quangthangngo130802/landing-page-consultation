<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationSurvey;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ConsultationSurvey::latest()->get();

            return DataTables::of($data)
                ->addColumn('checkbox', fn($row) => '<input type="checkbox" class="select-item" value="' . $row->id . '">')
                ->editColumn('full_name', fn($row) => '<strong>' . e($row->full_name) . '</strong>')
                ->editColumn('email', fn($row) => $row->email ?? 'Không có')
                ->editColumn('phone', fn($row) => $row->phone ?? 'Không có')
                ->editColumn('position', fn($row) => $row->position ?? 'Không có')
                ->editColumn('region', fn($row) => $row->region ?? 'Không có')
                ->editColumn('biggest_challenge', fn($row) => $row->biggest_challenge ?? 'Không có')
                ->editColumn('created_at', fn($row) => $row->created_at->format('d/m/Y H:i'))
                ->addColumn('actions', fn($row) => '
                <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '" title="Xóa">
                    <i class="fas fa-trash"></i>
                </button>')
                ->rawColumns(['checkbox', 'full_name', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.contact.index');
    }

    public function destroy($id)
    {
        $item = ConsultationSurvey::findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Xóa thành công!']);
    }
}