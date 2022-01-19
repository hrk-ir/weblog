<?php

namespace Modules\Category\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;

class CategoryRepo
{
    /**
     * return and get Model name
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return Category::query();
    }

    /**
     * return all categories with Subcategories relation
     * @return Builder
     */
    public function allWithSubCategories(): Builder
    {
        return $this->getQuery()->with(['subCategories'])
            ->where('status' , Category::STATUS_ACTIVE)
            ->where('parent_id' , null)
            ->latest();
    }

    /**
     * return specified category
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    /**
     * return specified category with Subcategories relation
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findByIdWithSubCategories($id)
    {
        return $this->getQuery()->with(['subCategories'])
            ->findOrFail($id);
    }

    /**
     * store a new category
     * @param $values
     * @return Builder|Model
     */
    public function store($values)
    {
        return $this->getQuery()->create(array_merge(
            $values->validated(),
            ['user_id' => auth()->user()->id , 'status' => Category::STATUS_ACTIVE]
        ));
    }

    /**
     * update specified category
     * @param $values
     * @param $id
     * @return bool|int
     */
    public function update($values , $id)
    {
        return $this->getQuery()->where('user_id' , auth()->user()->id)
            ->findOrFail($id)
            ->update(array_merge(
                $values,
                ['updated_at' => now()]
            ));
    }

}
