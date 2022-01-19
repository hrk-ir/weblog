<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Category\Entities\Category;
use Modules\Comment\Entities\Comment;
use Modules\User\Entities\User;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title' , 'slug' , 'image' , 'body' , 'category_id' , 'user_id'];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'  => 'datetime:Y-m-d',
        'updated_at'  => 'datetime:Y-m-d',
    ];

    /**
     * get user who create article
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * get category where belongs to article
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    /**
     * get comments where belongs to article
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->with('replies')->orderByDesc('created_at');
    }

    public function users_like(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'article_has_likes')
            ->withPivot(['article_id' , 'user_id'])
            ->withTimestamps();

    }

    /**
     * get image path from storage
     */
    public function getImagePathAttribute(): string
    {
        return '/storage/' . $this->image;
    }

    protected static function newFactory()
    {
        return \Modules\Article\Database\factories\ArticleFactory::new();
    }
}
