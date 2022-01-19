<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Article\Entities\Article;
use Modules\User\Entities\User;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id' , 'article_id' , 'reply_id' , 'body'];

    /**
     * get article where belongs to comment
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * get user where belongs to comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class , 'reply_id');
    }

    /**
     * get reply where belongs to comment
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class,'reply_id','id')
            ->whereHas('parentComment')
            ->with('replies');
    }


    protected static function newFactory()
    {
        return \Modules\Comment\Database\factories\CommentFactory::new();
    }
}
