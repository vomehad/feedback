<?php

namespace App\Services;

use App\Exceptions\NoFoundFeedbackException;
use App\Models\Feedback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class FeedbackService
{
    private Feedback $model;

    public function __construct(Feedback $feedback)
    {
        $this->model = $feedback;
    }

    public function getAll(array $options): LengthAwarePaginator
    {
        $feedbacks = $this->model->with($this->getRelationList());

        $feedbacks = $this->filter($feedbacks, $options);

        return $feedbacks->paginate();
    }

    private function getRelationList(): array
    {
        return [
            'user',
        ];
    }

    private function filter(Builder $entities, array $params): Builder
    {
        $listFilter = [
            'phone',
            'processed',
            'deleted',
        ];

        foreach (collect($params)->only($listFilter) as $key => $value) {
            if ($key === 'phone') {
                $entities = $entities->where('phone', 'like', "%{$value}%");
            }

            if ($key === 'processed') {
                $entities = $entities->whereRaw("processed = CAST({$value}) as BINARY");
            }

            if ($key === 'deleted') {
                if ($value == 'true') {
                    $entities = $entities->whereNull('deleted_at');
                }
                if ($value == 'false') {
                    $entities = $entities->whereNotNull('deleted_at');
                }
            }
        }

        return $entities;
    }

    public function create(array $data): Feedback
    {
        $this->model->fill($data);
        $this->model->user_id = auth()->id();
        $this->model->save();

        return $this->model;
    }

    /**
     * @param int $id
     * @return Feedback
     * @throws NoFoundFeedbackException
     */
    public function process(int $id): Feedback
    {
        /** @var Feedback $feedback */
        $feedback = $this->model->with($this->getRelationList())
            ->whereNull('deleted_at')
            ->where(['processed' => false])
            ->where(['id' => $id])
            ->first();

        if (!$feedback) {
            throw new NoFoundFeedbackException(__('message.feedback.no_found'));
        }

        $feedback->processed = true;
        $feedback->update();

        return $feedback;
    }
}
