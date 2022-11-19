<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\FaultResponse;
use App\Http\Resources\LoginResponse;
use App\Http\Resources\SuccessResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Auth",
 * )
 */
class AuthController extends ApiController
{
    private User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * * @OA\Post(
     *     path="/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="Авторизоваться",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Авторизован",
     *         @OA\JsonContent(ref="#/components/schemas/LoginResponse"),
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UserNotFoundException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->model->where(['email' => $data['email']])->first();

        if (!$user) {
            throw new UserNotFoundException(__('message.user.not_found'));
        }

        if (!Auth::attempt($data)) {
            return (new FaultResponse(__('message.user.not_auth')))
                ->response()
                ->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        $token = $this->model->createToken('')->plainTextToken;

        return (new LoginResponse($token))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     security={{"sanctum": {}}},
     *     summary="logout user",
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/JsonResponse"),
     *     ),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return (new SuccessResponse('logout'))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
