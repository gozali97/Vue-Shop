<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'inStock' => $this->inStock,
            'published' => $this->published == 1 ? 'Publish' : 'Arsip',
            'description' => $this->description,
            'category' => [
                'name' => $this->category->name,
//                'url' => route('category.show', $this->category),
            ],
            'brand' => [
                'name' => $this->brand->name,
//                'url' => route('category.show', $this->category),
            ],
        ];
    }
}
