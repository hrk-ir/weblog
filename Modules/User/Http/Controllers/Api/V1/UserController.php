<?php

namespace Modules\User\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Repositories\UserRepo;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public UserRepo $userRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepo $userRepo) {
        $this->middleware('auth:api');
        $this->userRepo = $userRepo;
    }
    /**
     * Get the User's likes.
     *
     * @return JsonResponse
     */
    public function articleLikes(): JsonResponse
    {
        $userLike = $this->userRepo->LikesUser()->get();

        return response()->json($userLike  , Response::HTTP_OK);
    }

    /**
     * Get the User's comments.
     *
     * @return JsonResponse
     */
    public function articleComments(): JsonResponse
    {
        $userLike = $this->userRepo->CommentsUSer()->get();

        return response()->json($userLike  , Response::HTTP_OK);
    }

    /**
     * Get the User's profile.
     *
     * @return JsonResponse
     */
    public function userProfile(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}
