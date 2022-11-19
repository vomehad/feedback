<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NoFoundFeedbackException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateFeedbackRequest;
use App\Http\Resources\FeedbackCollection;
use App\Http\Resources\FeedbackResponse;
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
     *     summary="Список заявки",
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
     * Store a newly created resource in storage.
     *
     * @param CreateFeedbackRequest $request
     * @return JsonResponse
     */
    public function store(CreateFeedbackRequest $request): JsonResponse
    {
        $data = $request->validated();

        $feedback = $this->feedbackService->create($data);

        return (new FeedbackResponse($feedback))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        //
    }
}
