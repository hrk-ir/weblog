<?php

namespace Modules\Article\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Article\Http\Requests\CreateRequest;
use Modules\Article\Http\Requests\UpdateRequest;
use Modules\Article\Http\Resources\CreateResources;
use Modules\Article\Http\Resources\IndexCollection;
use Modules\Article\Http\Resources\ShowResources;
use Modules\Article\Http\Resources\UpdateResources;
use Modules\Article\Repositories\ArticleRepo;
use Modules\Dashboard\Services\DashServices;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public ArticleRepo $articleRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ArticleRepo $articleRepo) {
        $this->middleware(['auth:api' , 'isAdmin']);
        $this->articleRepo = $articleRepo;
    }
    /**
     * Display a listing of the resource.
     * @return IndexCollection
     */
    public function index(): IndexCollection
    {
        $articles = $this->articleRepo->all()->paginate(10);
        return new IndexCollection($articles);
    }
    /**
     * Create a Article and return data.
     *
     * @param CreateRequest $request
     * @return CreateResources
     */
    public function store(CreateRequest $request): CreateResources
    {
        $image = DashServices::uploadImage($request->file('image') , 'Article');
        $article = $this->articleRepo->store($request->except(['image']) , $image);
        return new CreateResources($article);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return ShowResources
     */
    public function show(int $id): ShowResources
    {
        $article = $this->articleRepo->findByIdWithCategories($id);
        return new ShowResources($article);
    }
    /**
     * Update a Article and return data.
     *
     * @param UpdateRequest $request
     * @param $id
     * @return UpdateResources
     */
    public function update(UpdateRequest $request , $id): UpdateResources
    {
        if ($request->has('image')){
            $image = DashServices::uploadImage($request->file('image') , 'Article');
            $this->articleRepo->updateWithImage($request->except(['image']) , $id , $image);
        }else {
            $this->articleRepo->updateWithOutImage($request->except(['image']) , $id);
        }

        $article = $this->articleRepo->findById($id);
        return new UpdateResources($article);
    }

    /**
     * Delete  an Article and return message.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $article = $this->articleRepo->findById($id);
        $this->articleRepo->unlinkImage($article->image);
        $article->delete();
        return response()->json(['message' => 'This Article has successfully deleted'] , Response::HTTP_OK);
    }
}
