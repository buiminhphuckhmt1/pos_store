<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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
            'name'=> $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'barcode' => $this->barcode,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'unit_sale' => $this->unit_sale,
            'unit_purchas' => $this->unit_purchas,
            'inputprice' => $this->inputprice,
            'outputprice' => $this->outputprice,
            'discountpercen' => $this->discountpercen,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'image_url' => Storage::url($this->image)
        ];
    }
}
