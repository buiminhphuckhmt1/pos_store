<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'id'=> $this->id,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'role_id'=>$role_id,
            'last_name'=> $this->last_name,
            'created_at' => $this->created_at
        ];
    }
}
