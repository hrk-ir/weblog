<?php

namespace Modules\Article\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;

class ShowResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'slug'     => $this->slug,
            'image'    => $this->getImagePathAttribute(),
            'body'     => $this->body,
            'category_name'  => $this->categories->title,
            'users_like_count' => $this->users_like_count,
            'comments_count' => $this->comments_count,
            'comments' => $this->comments,
            'user_name'      => $this->user->name,
            'created_at'     => (string) $this->created_at,
        ];
    }


    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'with' => [
                'message' => 'The Specified Articles has Display Successfully',
                'status'  => Response::HTTP_OK
            ],
        ];
    }
}
