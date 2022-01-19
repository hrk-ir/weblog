<?php

namespace Modules\Article\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Article\Entities\Article;
use Modules\Category\Entities\Category;
use Modules\Dashboard\Services\DashServices;

class ArticleRepo
{
    /**
     * return Name Of Model
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return Article::query();
    }

    /**
     * return Articles orderBy latest with categories , user , comments relationship
     * @return Builder
     */
    public function all(): Builder
    {
        return $this->getQuery()->with(['categories' , 'user' , 'comments' => function ($query) {
            $query->where('reply_id' , null);
        }])
            ->withCount('users_like')
            ->withCount('comments')
            ->latest();
    }

    /**
     * return specified article
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    /**
     * return specified article with categories , user , comments relationship and count of users like and comment
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findByIdWithCategories($id)
    {
        return $this->getQuery()->with(['categories', 'user' , 'comments' => function ($query) {
            $query->where('reply_id' , null);
        }])
            ->withCount('users_like')
            ->withCount('comments')
            ->findOrFail($id);
    }

    /**
     * return articles groupBy categories with user  and count of users like and comment orderBy created_at
     * @return Builder[]|Collection
     */
    public function ArticlesGroupByCategory()
    {
        return $this->getQuery()->with(['categories' , 'user'])
            ->withCount('users_like')
            ->withCount('comments')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('categories.title');
    }

    /**
     * store a new article
     * @param $values
     * @param $image
     * @return Builder|Model
     */
    public function store($values, $image)
    {
        return $this->getQuery()->create([
            'title' => $values['title'],
            'slug' => DashServices::generateSlug($values['title']),
            'image' => $image,
            'body' => $values['body'],
            'category_id' => $values['category_id'],
            'user_id' => auth()->user()->id
        ]);
    }

    /**
     * update specified article with Image request
     * @param $values
     * @param $id
     * @param $image
     * @return bool|int
     */
    public function updateWithImage($values, $id, $image)
    {
        return $this->getQuery()->where('user_id', auth()->user()->id)
            ->findOrFail($id)
            ->update(array_merge(
                $values->validated(),
                ['image' => $image,
                    'slug' => DashServices::generateSlug($values['title']),
                    'updated_at' => now()]
            ));
    }

    /**
     * update specified article without Image request
     * @param $values
     * @param $id
     * @return bool|int
     */
    public function updateWithOutImage($values, $id)
    {
        return $this->getQuery()->where('user_id', auth()->user()->id)
            ->findOrFail($id)
            ->update(array_merge(
                $values->validated()),
                ['updated_at' => now()]
            );
    }

    /**
     * remove specified image from storage
     * @param $path
     * @return bool
     */
    public function unlinkImage($path): bool
    {
        return  unlink(storage_path('app/public/'.$path));
    }
}
