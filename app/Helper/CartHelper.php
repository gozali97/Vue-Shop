<?php

namespace App\Helper;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Arr;

class CartHelper
{
    public static function getCount()
    {
        if ($user = auth()->user()){
            return Cart::whereUserId($user->id)->sum('quantity');
        }
    }

    public static function getCartItem(){

        if($user = auth()->user()){
            return Cart::whereUserId($user->id)->get()->map(fn (Cart $item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]);
        }
    }

    public static function getCookieCartItems(){
        return json_decode(request()->cookie('cart_items', '[]'), true);
    }

    public static function setCookieCartItems(){
        Cookie::queue('cart_items', fn(int $carry, array $item)=>$carry + $item['quantity'],0);
    }

    public static function saveCookieCartItems(){
        $user = auth()->user();
        $userCartItems = Cart::where(['user_id'=> $user->id])->get()->keyBy('product_id');
        $saveCartItems = [];
        foreach (self::getCookieCartItems() as $cartItem){
            if(isset($userCartItems[$cartItem['product_id']])){
                $userCartItems[$cartItem['product_id']]->update(['quantity' => $cartItem['quantity']]);
                continue;
            }

            $saveCartItems[] = [
                'user_id' => $user->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
            ];
        }

        if(!empty($saveCartItems)){
            Cart::insert($saveCartItems);
        }
    }

    public static function moveCartItemsIntoDb(){
        $request = request();
        $cartItems = self::getCookieCartItems();
        $newCartItems = [];
        foreach ($cartItems as $cartItem) {
            // Check if the record already exists in the database
            $existingCartItem = Cart::where([
                'user_id' => $request->user()->id,
                'product_id' => $cartItem['product_id'],
            ])->first();

            if (!$existingCartItem) {
                // Only insert if it doesn't already exist
                $newCartItems[] = [
                    'user_id' => $request->user()->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                ];
            }
        }


        if (!empty($newCartItems)) {
            // Insert the new cart items into the database
            Cart::insert($newCartItems);
        }
    }

    public static function getProductsAndCartItems()
    {
        $cartItems = self::getCartItems();

        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Product::whereIn('id', $ids)->with('product_images')->get();
        $cartItems = Arr::keyBy($cartItems, 'product_id');
        return [$products, $cartItems];
    }
}
