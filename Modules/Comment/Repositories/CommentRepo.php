<?php

namespace Modules\Comment\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Comment\Entities\Comment;

class CommentRepo
{
    /**
     * return Model Name
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return Comment::query();
    }

    /**
     * retrieve list of All comment
     * @return Builder
     */
    public function all(): Builder
    {
        return $this->getQuery()->latest();
    }

    /**
     * store a new comment
     * @param $value
     * @return Builder|Model
     */
    public function store($value)
    {
        return $this->getQuery()->create(array_merge($value, ['user_id' => auth()->user()->id]));
    }

}
