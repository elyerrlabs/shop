<?php

namespace Shop\App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use Shop\App\Services\CategoryService;
use Shop\App\Transformer\Admin\CategoryTransformer;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Shop\App\Http\Requests\Category\StoreRequest;

class CategoryController extends ApiController
{
    /**
     * Category
     * @var CategoryService
     */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
        $this->middleware('scope:administrator:ecommerce:full,administrator:ecommerce:view')->only('index', 'show');
        $this->middleware('scope:administrator:ecommerce:full,administrator:ecommerce:store')->only('store');
        $this->middleware('scope:administrator:ecommerce:full,administrator:ecommerce:delete')->only('destroy');
    }

    /**
     * Show all resources
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        $query = $this->categoryService->search($request);

        return $this->showAllByBuilder($query, CategoryTransformer::class);
    }

    /**
     * Edit
     * @param Request $request
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function show(Request $request, string $id)
    {
        $model = $this->categoryService->details($id);

        return $this->showOne($model, CategoryTransformer::class);
    }

    /**
     * Create new resource
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $request->merge([
            'description' => Purify::clean($request->description),
        ]);

        // Update resource
        if (!empty($request->filled('id')) && $this->categoryService->details($request->id)) {
            $model = $this->categoryService->update($request->id, $request->toArray());
            return $this->showOne($model, CategoryTransformer::class);
        }

        // Create one
        $request->merge([
            'slug' => normalizeSlug($request->name),
            'description' => Purify::clean($request->description),
        ]);

        $model = $this->categoryService->create($request->toArray());

        return $this->showOne($model, CategoryTransformer::class, 201);
    }


    /**
     * Destroy resource
     * @param string $category_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(string $category_id)
    {
        $model = $this->categoryService->delete($category_id);
        return $this->showOne($model, CategoryTransformer::class);
    }
}
