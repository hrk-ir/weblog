<?php

namespace Modules\Category\Http\Resources;

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
            'id'      => $this->id,
            'title'   => $this->title,
            'status'  => $this->status,
            'parent_id'  => $this->parent_id,
            'parent_name'  => $this->getParentAttribute(),
            'subCategories'  => $this->subCategories,
            'created_at'  => (string) $this->created_at,
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
                'message' => 'Category Results Has Display Successfully',
                'status'  => Response::HTTP_OK
            ],
        ];
    }
}
