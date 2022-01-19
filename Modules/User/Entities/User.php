<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Article\Entities\Article;
use Modules\Category\Entities\Category;
use Modules\Comment\Entities\Comment;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d',
        'created_at'  => 'datetime:Y-m-d',
        'updated_at'  => 'datetime:Y-m-d',
    ];

    /** Roles  */

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public static array $roles = [self::ROLE_ADMIN , self::ROLE_USER];


    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function articles(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function articles_like(): BelongsToMany
    {
        return $this->belongsToMany(Article::class,'article_has_likes')
            ->withPivot(['article_id' , 'user_id'])
            ->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->with('replies');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
