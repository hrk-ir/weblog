<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Article\Entities\Article;
use Modules\User\Entities\User;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title' , 'parent_id' , 'status' , 'user_id'];

    /** Status  */

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public static array $status = [self::STATUS_ACTIVE , self::STATUS_INACTIVE];

    public function getParentAttribute(): string
    {
        return (is_null($this->parent_id)) ? 'Not Found Any Parent' : $this->parentCategory->title;
    }
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class , 'parent_id');
    }
    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->whereHas('parentCategory')
            ->with('subcategories');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function newFactory()
    {
        return \Modules\Category\Database\factories\CategoryFactory::new();
    }
}
