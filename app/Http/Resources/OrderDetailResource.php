<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'order_id' => $this->order_id,
            'gross_amount' => intval($this->gross_amount),
            'status' => $this->status,
            'paid_at' => $this->paid_at,
            'courir' => $this->courir,
            'courir_type' => $this->courir_type,
            'courir_price' => $this->courir_price,
            'items' => $this->items->map(function ($item) {
                return [
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'product' => [
                        'title' => $item->product->title,
                    ]
                ];
            }),
        ];
    }
}
