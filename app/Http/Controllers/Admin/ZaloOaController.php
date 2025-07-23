<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Automation;
use App\Models\Template;
use App\Models\ZaloOa;
use App\Services\TemplateService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZaloOaController extends Controller
{
    //
    public $templateService;
    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }
    public function updateOa(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name_oa' => 'required',
            'oa_id' => 'required',
            'access_token' => 'required',
            'refresh_token' => 'required',
        ]);

        $zaloOa = ZaloOa::first() ?? new ZaloOa();
        $zaloOa->fill($validated)->save();
        $this->templateService->template();
        return handleResponse("Thành công", 201);
    }

    public function template()
    {
        // $this->templateService->zns();
        $automation = Automation::with('template')->first() ?? [];
        $templates = Template::get();
        $template_automation = Template::where('status', 'ENABLE')->get();
        $template_first = Template::first() ?? [];
        return view('backend.marketing.template.index', compact('templates', 'template_first', 'template_automation','automation'));
    }

    public function detailTemplate(Request $request)
    {
        $template_first = Template::find($request->id);

        // dd($template_first);

        if (!$template_first) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found!'
            ], 404);
        }

        $renderedView = view('backend.marketing.template.detail', [
            'template_first' => $template_first
        ])->render();

        return response()->json([
            'success' => true,
            'message' => 'Truy vấn thành công!',
            'html' => $renderedView,
        ]);
    }

    public function automationTemplate(Request $request)
    {
        $template_first = Template::find($request->id);

        $automation = Automation::first() ?? new Automation();
        $automation->template_id = $template_first->id;
        $automation->save();
        if (!$template_first) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thành công!',

        ]);
    }
}
