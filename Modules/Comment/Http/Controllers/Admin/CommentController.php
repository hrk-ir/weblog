<?php

namespace Modules\Comment\Http\Controllers\Admin;

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
    public CommentRepo $commentRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(CommentRepo $commentRepo) {
        $this->middleware(['auth:api' , 'isAdmin']);
        $this->commentRepo = $commentRepo;
    }

    /**
     * retrieve list of All comment
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->commentRepo->all()->get());
    }

}
