<?php

namespace Modules\User\Http\Controllers\Admin;

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
        $this->middleware(['auth:api' , 'isAdmin']);
        $this->userRepo = $userRepo;
    }
    /**
     * Get the List User.
     *
     * @return JsonResponse
     */
    public function users(): JsonResponse
    {
        return response()->json($this->userRepo->all()->paginate(20) , Response::HTTP_OK);
    }
}
