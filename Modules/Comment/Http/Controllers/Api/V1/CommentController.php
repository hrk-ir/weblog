<?php

namespace Modules\Comment\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Article\Repositories\ArticleRepo;
use Modules\Comment\Http\Requests\CreateRequest;
use Modules\Comment\Http\Requests\RemoveRequest;
use Modules\Comment\Repositories\CommentRepo;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public ArticleRepo $articleRepo;
    public CommentRepo $commentRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ArticleRepo $articleRepo , CommentRepo $commentRepo) {
        $this->middleware(['auth:api']);
        $this->articleRepo = $articleRepo;
        $this->commentRepo = $commentRepo;
    }

    /**
     * comment an Article and return message.
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function addComment(CreateRequest $request): JsonResponse
    {
        $this->commentRepo->store($request->validated());
        return response()->json(['message' => 'you add new comment the article'] , Response::HTTP_CREATED);
    }

    /**
     * find a comment by id and remove them final return message.
     *
     * @param RemoveRequest $request
     * @return JsonResponse
     */
    public function removeComment(RemoveRequest $request): JsonResponse
    {
        $comment = $this->commentRepo->findById($request->comment_id);
        $comment->delete();

        return response()->json(['message' => 'you just remove yours comment'] , Response::HTTP_OK);
    }
}
