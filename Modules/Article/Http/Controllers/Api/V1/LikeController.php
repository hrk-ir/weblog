<?php

namespace Modules\Article\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Modules\Article\Repositories\ArticleRepo;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;


class LikeController extends Controller
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
     * like an Article and return message.
     *
     * @param $id
     * @return JsonResponse
     */
    public function addLikesToArticle($id): JsonResponse
    {
        $article = $this->articleRepo->findById($id);
        $article->users_like()->attach(auth()->user()->id);

        return response()->json(['message' => 'you like the article'] , Response::HTTP_CREATED);
    }
    /**
     * Dislike an Article and return message.
     *
     * @param $id
     * @return JsonResponse
     */
    public function removeLikesToArticle($id): JsonResponse
    {
        $article = $this->articleRepo->findById($id);
        $article->users_like()->detach();

        return response()->json(['message' => 'you dislike the article'] , Response::HTTP_CREATED);
    }
}
