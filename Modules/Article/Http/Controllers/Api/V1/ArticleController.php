<?php

namespace Modules\Article\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Article\Http\Requests\CreateRequest;
use Modules\Article\Http\Requests\UpdateRequest;
use Modules\Article\Http\Resources\ArticleCategoryCollection;
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
        $this->middleware(['auth:api']);
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
     * Show the specified category's Articles.
     * @return ArticleCategoryCollection
     */
    public function ArticlesByCategories(): ArticleCategoryCollection
    {
        $categoryArticles = $this->articleRepo->ArticlesGroupByCategory();
        return new ArticleCategoryCollection($categoryArticles);
    }

}
