<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\RankmathSEOForLaravel\Services\SeoAnalyzer;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{

    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Post::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (request()->ajax()) {
            $columns = ['id', 'title', 'slug', 'image', 'address', 'status', 'type'];

            $query = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('title', fn($row) => " <a href='" . route('admin.posts.edit', $row) . "'>
                    <strong>{$row->title}</strong>
                </a>")
                    ->editColumn('statuss', fn($row) => $row->status == 1
                        ? '<span class="badge bg-success">Xuất bản</span>'
                        : '<span class="badge bg-warning">Chưa xuất bản</span>')
                    ->editColumn('types', fn($row) => $row->type == 'customer'
                        ? '<span class="badge bg-primary">Khách hàng</span>'
                        : '<span class="badge bg-info text-dark">Tin tức</span>');

            }, ['title', 'statuss', 'types']);
        }
        return view('backend.post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $seoData = $this->getSeoAnalysis($request);
        return view('backend.post.save', compact('seoData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        return transaction(function () use ($request) {

            $credentials = $request->validated();


            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['title']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'post');
            }

            if (!empty($credentials['keyword_seo'])) {
                if (is_string($credentials['keyword_seo'])) {
                    $decoded = json_decode($credentials['keyword_seo'], true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $keywords = collect($decoded)->pluck('value')->filter()->toArray();
                        $focusKeyword = $keywords[0] ?? '';
                        // $credentials['keyword_seo'] = json_encode($decoded);
                    } else {
                        $keywords = explode(',', $credentials['keyword_seo']);
                        $keywords = array_map('trim', $keywords);
                        $focusKeyword = $keywords[0] ?? '';
                        // $credentials['keyword_seo'] = implode(', ', $keywords);
                    }
                }
            } else {
                $focusKeyword = '';
            }


            $analyzer = app(SeoAnalyzer::class);
            $analysisResult = $analyzer->analyze(
                $credentials['title_seo'],
                $credentials['description'],
                $focusKeyword,
                $credentials['description_seo'] ?? '',
                $credentials['slug']
            );

            $analysis = collect($analysisResult->checks ?? []);
            $suggestions = collect($analysisResult->suggestions ?? []);
            $seoScoreValue = $this->calculateSeoScore($analysis, $suggestions);

            Post::create($credentials);

            sessionFlash('success', 'Thêm mới bài thành công.');

            return handleResponse('Thêm mới bài thành công.', 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, Request $request)
    {
        //
        // dd($post);
        $seoData = $this->getSeoAnalysis($request);

        return view('backend.post.save', compact('post', 'seoData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {

        return transaction(function () use ($request, $post) {

            $credentials = $request->validated();


            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['title']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'post');
            }

            // if (!empty($credentials['keyword_seo'])) {
            //     $credentials['keyword_seo'] = $credentials['keyword_seo'];
            // }
            // dd($credentials);



            Log::info($credentials);
            $post->update($credentials);

            $seoData = $this->getSeoAnalysis(new Request(), $post->id);
            $seoScoreValue = $seoData['seoScoreValue'];

            sessionFlash('success', 'Thêm mới bài thành công.');

            return handleResponse('Thêm mới bài thành công.', 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }


    // Tính điểm
    private function calculateSeoScore($analysis, $suggestions)
    {
        $allItems = collect($analysis)->merge($suggestions);

        $totalCriteria = $allItems->count();

        $successCount = $allItems->where('status', 'success')->count();
        $warningCount = $allItems->where('status', 'warning')->count();
        $failCount = $allItems->where('status', 'danger')->count();

        if ($totalCriteria === 0) {
            return 0;
        }

        $score = ($successCount * 1 + $warningCount * 0.5 + $failCount * 0) / $totalCriteria * 100;

        return round($score);
    }

    public function getSeoAnalysis(Request $request, $id = null)
    {
        if (!$id) {
            return [
                'post' => null,
                'seoScore' => null,
                'keywords' => [],
                'analysis' => [],
                'suggestions' => [],
                'hasWarning' => false,
                'seoScoreValue' => 0,
            ];
        }

        $post = Post::findOrFail($id);

        $seoKeywords = $request->input('keyword_seo', []);
        $focusKeyword = is_array($seoKeywords) ? ($seoKeywords[0] ?? '') : $seoKeywords;

        $analyzer = app(SeoAnalyzer::class);
        // dd($new->title_seo, $new->description, $focusKeyword, $new->seo_description ?? '', $new->slug);

        $analysisResult = $analyzer->analyze($post->title_seo = '', $post->description, $focusKeyword, $blog->seo_description ?? '', $post->slug);

        $analysis = collect($analysisResult->checks)->map(function ($item) {
            $status = $item['status'] ?? ($item['passed'] ? 'success' : 'warning');
            return array_merge($item, ['status' => $status]);
        })->toArray();

        $suggestions = collect($analysisResult->suggestions ?? [])->map(function ($item) {
            $status = $item['status'] ?? ($item['passed'] ? 'success' : 'info');
            return array_merge($item, ['status' => $status]);
        })->toArray();


        $seoScoreValue = $this->calculateSeoScore($analysis, $suggestions);
        $hasWarning = $seoScoreValue < 80 || collect($analysis)->contains(fn($item) => $item['passed'] === false);

        // $seoScore = SeoScoreNews::where('new_id', $new->id)->first();

        return [
            'post' => $post,
            // 'seoScore' => $seoScore,
            'keywords' => $post->keywords,
            'analysis' => $analysis,
            'suggestions' => $suggestions,
            'hasWarning' => $hasWarning,
            'seoScoreValue' => $seoScoreValue,
        ];
    }

    public function getSeoAnalysisLive(Request $request)
    {
        $seoTitle = $request->title_seo ?? '';
        $description = $request->description ?? '';
        $slug = $request->slug ?? '';
        $seoDescription = $request->seo_description ?? '';
        $seoKeywords = $request->input('keyword_seo', []);
        $focusKeyword = is_array($seoKeywords) ? ($seoKeywords[0] ?? '') : $seoKeywords;

        $analyzer = app(SeoAnalyzer::class);

        $analysisResult = $analyzer->analyze($seoTitle, $description, $focusKeyword, $seoDescription, $slug);
        $analysis = collect($analysisResult->checks)->map(function ($item) {
            $status = $item['status'] ?? ($item['passed'] ? 'success' : 'warning');
            return array_merge($item, ['status' => $status]);
        })->toArray();

        $suggestions = collect($analysisResult->suggestions ?? [])->map(function ($item) {
            $status = $item['status'] ?? ($item['passed'] ? 'success' : 'info');
            return array_merge($item, ['status' => $status]);
        })->toArray();

        $seoScoreValue = $this->calculateSeoScore($analysis, $suggestions);
        $hasWarning = $seoScoreValue < 80 || collect($analysis)->contains(fn($item) => $item['passed'] === false);

        $seoData = [
            'analysis' => $analysis,
            'suggestions' => $suggestions,
            'seoScoreValue' => $seoScoreValue,
            'hasWarning' => $hasWarning,
        ];

        $seoScoreValue = $seoData['seoScoreValue'] ?? 0;
        $seoColor = 'bg-danger'; // đỏ mặc định (dưới 50)
        $badgeClass = 'bg-danger';

        if ($seoScoreValue >= 80) {
            $seoColor = 'bg-success'; // xanh lá (tốt)
            $badgeClass = 'bg-success';
        } elseif ($seoScoreValue >= 50) {
            $seoColor = 'bg-warning'; // vàng (trung bình)
            $badgeClass = 'bg-warning text-dark';
        }

        // dd(vars: $seoData);

        $view = view('backend.post.seo', compact('seoData'))->render();
        return response()->json([
            'success' => true,
            'html' => $view,
            'seoScoreVal' => $seoScoreValue,
            'seoColor' => $seoColor,
            'badgeClass' => $badgeClass
        ]);
    }
}
