<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Modules\Category\Http\Requests\CreateRequest;
use Modules\Category\Http\Requests\UpdateRequest;
use Modules\Category\Http\Resources\CreateResources;
use Modules\Category\Http\Resources\IndexCollection;
use Modules\Category\Http\Resources\ShowResources;
use Modules\Category\Http\Resources\UpdateResources;
use Modules\Category\Repositories\CategoryRepo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public CategoryRepo $categoryRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(CategoryRepo $categoryRepo) {
        $this->middleware(['auth:api']);
        $this->categoryRepo = $categoryRepo;
    }
    /**
     * Display a listing of the resource.
     * @return IndexCollection
     */
    public function index(): IndexCollection
    {
        $categories = $this->categoryRepo->allWithSubCategories()->get();
        return new IndexCollection($categories);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return ShowResources
     */
    public function show(int $id): ShowResources
    {
        $category = $this->categoryRepo->findByIdWithSubCategories($id);
        return new ShowResources($category);
    }

}
