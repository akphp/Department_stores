<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConstantResoures extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'user_id' => UserCollection::collection($this->user_id),
            'active' =>  $this->is_active,
            'created at' => $this->created_at,
            'Last updated' => $this->updated_at,
        ];

    }
}
