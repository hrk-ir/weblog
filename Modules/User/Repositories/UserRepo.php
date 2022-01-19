<?php

namespace Modules\User\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;

class UserRepo
{
    /**
     * return Name Of Model
     */
    public function getQuery(): Builder
    {
        return User::query();
    }

    /**
     * return users orderBy latest
    */
    public function all(): Builder
    {
        return $this->getQuery()->latest();
    }

    /**
     * find and return user by email
     * @param $value
     * @return Builder|Model
     */
    public function findByEmail($value)
    {
        return $this->getQuery()->where('id' , auth()->user()->id)
            ->where('email' , $value)->firstOrFail();
    }

    /**
     * find and return which article liked by user
     * @return Builder
     */
    public function LikesUser(): Builder
    {
       return $this->getQuery()->where('id' , auth()->user()->id)
           ->with('articles_like')
           ->withCount('articles_like')
           ->latest();
    }

    /**
     * find and return which article comment by user
     * @return Builder
     */
    public function CommentsUSer(): Builder
    {
        return $this->getQuery()->where('id' , auth()->user()->id)
            ->with('comments')
            ->withCount('comments')
            ->latest();
    }

    /**
     * find and update user password
     * @param $values
     * @return bool|int
     */
    public function updatePassword($values)
    {
        return $this->getQuery()
            ->where('id' , auth()->user()->id)
            ->where('email' , $values->email)
            ->firstOrFail()->update([
                'password' => Hash::make($values->password)
            ]);
    }
}
