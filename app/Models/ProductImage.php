<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function productImage(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function cartProductImage(){
        return $this->belongsTo(Cart::class, 'product_id', 'product_id');
    }
}
