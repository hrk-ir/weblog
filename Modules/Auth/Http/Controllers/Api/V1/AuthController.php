<?php

namespace Modules\Auth\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\UpdatePasswordRequest;
use Modules\Auth\Http\Resources\RegisterResource;
use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepo;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public bool $loginAfterSignUp = true;
    public UserRepo $UserRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepo $UserRepo) {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->userRepo = $UserRepo;
    }

    /**
     * Register a User and assign a role.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $token = 'userDataWithToken';
        //  when created user then check if user exists assign role user else assign role admin
        $firstUser = User::query()->first();
        if ($firstUser) {
            User::query()->create(array_merge(
                $request->validated(),
                ['password' => bcrypt($request->password)]
            ));
        }else {
             User::query()->create(array_merge(
                $request->validated(),
                ['password' => bcrypt($request->password) ,
                 'role' => User::ROLE_ADMIN]
            ));
        }
        if ($this->loginAfterSignUp) {
            $token =  auth()->attempt($request->validated());
        }
        return $this->createNewToken($token);
    }


    /**
     * Get a JWT via given credentials.
     * @param LoginRequest $request
     * @return JsonResponse
     */

    public function login(LoginRequest $request): JsonResponse
    {
        if (! $token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->createNewToken($token);
    }

    /**
     * Get a JWT via given credentials.
     * @param UpdatePasswordRequest $request
     * @return JsonResponse
     */
    public function ResetPassword(UpdatePasswordRequest $request): JsonResponse
    {
        if (Hash::check($request->old_password, auth()->user()->password)) {
            $this->userRepo->updatePassword($request);
            return response()->json(['message' => 'password was changed'] , Response::HTTP_OK);
        }
            return response()->json(['message' => 'your old password does not match'] , Response::HTTP_UNAUTHORIZED);


    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out'] , Response::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function createNewToken(string $token): JsonResponse
    {
        return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => now()->addHours(3)->format('Y-m-d | H:i'),
                'user' => auth()->user()
            ], Response::HTTP_OK
        );
    }

}
