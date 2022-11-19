<?php

namespace App\Repositories;

use App\Exceptions\BaseException;
use App\Exceptions\NoFoundFeedbackException;
use App\Models\Feedback;

class FeedbackRepository
{
    private Feedback $model;

    public function __construct(Feedback $feedback)
    {
        $this->model = $feedback;
    }

    /**
     * @param int $id
     * @return Feedback
     * @throws NoFoundFeedbackException
     */
    public function getOne(int $id): Feedback
    {
        /** @var Feedback $feedback */
        $feedback = $this->model->with($this->getRelationList())
            ->whereNull('deleted_at')
            ->where(['id' => $id])
            ->first();

        if (!$feedback) {
            throw new NoFoundFeedbackException(__('message.feedback.no_found'));
        }

        $feedback->processed = true;
        $feedback->update();

        return $feedback;
    }

    private function getRelationList(): array
    {
        return [
            'user'
        ];
    }

    /**
     * @param array $data
     * @param int $id
     * @return Feedback
     * @throws BaseException|NoFoundFeedbackException
     */
    public function update(array $data, int $id): Feedback
    {
        $feedback = $this->getOne($id);

        try {
            $feedback->fill($data);

            $feedback->update();
        } catch (\Throwable $exception) {
            throw new BaseException($exception->getMessage());
        }

        return $feedback;
    }

    /**
     * @param int $id
     * @throws NoFoundFeedbackException|BaseException
     */
    public function remove(int $id)
    {
        $feedback = $this->getOne($id);

        try {
            $feedback->delete();
        } catch (\Throwable $exception) {
            throw new BaseException($exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @throws NoFoundFeedbackException|BaseException
     */
    public function restore(int $id)
    {
        /** @var Feedback $feedback */
        $feedback = $this->model->where(['id' => $id])->onlyTrashed()->first();

        if (!$feedback) {
            throw new NoFoundFeedbackException(__('message.feedback.no_found'));
        }

        try {
            $feedback->deleted_at = null;
            $feedback->update();
        } catch (\Throwable $exception) {
            throw new BaseException($exception->getMessage());
        }
    }
}
