<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BaseException;
use App\Exceptions\NoFoundFeedbackException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Http\Resources\FeedbackCollection;
use App\Http\Resources\FeedbackResponse;
use App\Http\Resources\SuccessResponse;
use App\Repositories\FeedbackRepository;
use App\Services\FeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Feedback",
 * )
 */
class FeedbackController extends ApiController
{
    private FeedbackService $feedbackService;
    private FeedbackRepository $feedbackRepository;

    public function __construct(FeedbackService $feedbackService, FeedbackRepository $feedbackRepository)
    {
        $this->feedbackService = $feedbackService;
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @OA\Get(
     *     path="/feedbacks",
     *     operationId="feedbackAll",
     *     tags={"Feedback"},
     *     summary="Список отзывов",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="processed",
     *         in="query",
     *         example="true",
     *         description="true | false"
     *     ),
     *     @OA\Parameter(
     *         name="deleted",
     *         in="query",
     *         example="true",
     *         description="true | false"
     *     ),
     *     @OA\Parameter(
     *         name="number",
     *         in="query",
     *         example="99539393",
     *         description="number phone"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/FeedbackItem"),
     *             )
     *         ),
     *      ),
     *     @OA\Response(
     *         response="401",
     *         description="Неавторизован",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $feedbacks = $this->feedbackService->getAll($request->query->all());

        return (new FeedbackCollection($feedbacks))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/feedbacks",
     *     operationId="clientFeedback",
     *     tags={"Feedback"},
     *     summary="Добавление отзыва",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FeedbackStoreRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/JsonResponse"),
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Ошибки валидации",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultValidation"),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Неавторизован",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     * )
     *
     * @param FeedbackRequest $request
     * @return JsonResponse
     * @throws BaseException
     */
    public function store(FeedbackRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->feedbackService->create($data);

        return (new SuccessResponse(__('message.feedback.saved')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/feedbacks/{id}",
     *     operationId="getFeedback",
     *     tags={"Feedback"},
     *     summary="Получить инфо отзыва",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/FeedbackItem"),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Неавторизован",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Не найден",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     * )
     *
     * @param int $id
     * @return JsonResponse
     * @throws NoFoundFeedbackException
     */
    public function show(int $id): JsonResponse
    {
        $feedback = $this->feedbackRepository->getOne($id);

        return (new FeedbackResponse($feedback))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Patch(
     *     path="/feedbacks/{id}",
     *     operationId="updateFeedback",
     *     tags={"Feedback"},
     *     summary="Обновить инфо отзыва",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FeedbackUpdateRequest")
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="Успешно обновлено",
     *         @OA\JsonContent(ref="#/components/schemas/JsonResponse"),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Неавторизован",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Не найден",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Ошибки валидации",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultValidation"),
     *     ),
     * )
     *
     * @param UpdateFeedbackRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws BaseException|NoFoundFeedbackException
     */
    public function update(UpdateFeedbackRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $this->feedbackRepository->update($data, $id);

        return (new SuccessResponse(__('message.feedback.updated')))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/feedbacks/{id}",
     *     operationId="deleteFeedback",
     *     tags={"Feedback"},
     *     summary="Удалить отзыв",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Успешно удалён",
     *         @OA\JsonContent(ref="#/components/schemas/JsonResponse"),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Неавторизован",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Не найден",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     * )
     *
     * @param int $id
     * @return JsonResponse
     * @throws NoFoundFeedbackException
     * @throws BaseException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->feedbackRepository->remove($id);

        return (new SuccessResponse(__('message.feedback.deleted')))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/feedbacks/{id}/restore",
     *     operationId="restoreFeedback",
     *     tags={"Feedback"},
     *     summary="Восстановить отзыв",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Успешно восстановлен",
     *         @OA\JsonContent(ref="#/components/schemas/JsonResponse"),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Неавторизован",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Не найден",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     * )
     *
     * @param int $id
     * @return JsonResponse
     * @throws BaseException|NoFoundFeedbackException
     */
    public function restore(int $id): JsonResponse
    {
        $this->feedbackRepository->restore($id);

        return (new SuccessResponse(__('message.feedback.restored')))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/feedbacks/{id}/proessed",
     *     operationId="proessedFeedback",
     *     tags={"Feedback"},
     *     summary="Отметить обработанным отзыв",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Успешно",
     *         @OA\JsonContent(ref="#/components/schemas/JsonResponse"),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Неавторизован",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Не найден",
     *         @OA\JsonContent(ref="#/components/schemas/JsonFaultResponse"),
     *     ),
     * )
     *
     * @param int $id
     * @return JsonResponse
     * @throws BaseException|NoFoundFeedbackException
     */
    public function processed(int $id): JsonResponse
    {
        $this->feedbackService->process($id);

        return (new SuccessResponse(__('message.feedback.processed')))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
