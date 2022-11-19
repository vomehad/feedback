<?php

namespace App\Repositories;

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
     * @param int $id
     * @throws NoFoundFeedbackException
     */
    public function remove(int $id)
    {
        $feedback = $this->getOne($id);
        $feedback->delete();
    }

    /**
     * @param int $id
     * @return Feedback
     * @throws NoFoundFeedbackException
     */
    public function restore(int $id)
    {
        /** @var Feedback $feedback */
        $feedback = $this->model->where(['id' => $id])->onlyTrashed()->first();

        if (!$feedback) {
            throw new NoFoundFeedbackException(__('message.feedback.no_found'));
        }

        $feedback->deleted_at = null;

        return $feedback;
    }
}
