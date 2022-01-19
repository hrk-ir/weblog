<?php

namespace Modules\Category\Http\Controllers\Admin;

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
        $this->middleware(['auth:api' , 'isAdmin']);
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
     * Create a Category and return data.
     *
     * @param CreateRequest $request
     * @return CreateResources
     */
    public function store(CreateRequest $request): CreateResources
    {
        $category = $this->categoryRepo->store($request);
        return new CreateResources($category);
    }

    /**
     * Show the specified Category.
     * @param int $id
     * @return ShowResources
     */
    public function show(int $id): ShowResources
    {
        $category = $this->categoryRepo->findByIdWithSubCategories($id);
        return new ShowResources($category);
    }

    /**
     * Update a Category and return data.
     *
     * @param UpdateRequest $request
     * @param $id
     * @return UpdateResources
     */
    public function update(UpdateRequest $request , $id): UpdateResources
    {
        $this->categoryRepo->update($request->validated() , $id);
        $category = $this->categoryRepo->findById($id);
        return new UpdateResources($category);
    }

    /**
     * Delete a Category and return message.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $category = $this->categoryRepo->findById($id);
        $category->delete();
        return response()->json(['message' => 'this Category has successfully deleted'] , Response::HTTP_OK);
    }

}
