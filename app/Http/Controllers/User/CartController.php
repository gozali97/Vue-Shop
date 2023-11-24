<?php

namespace App\Http\Controllers\User;

use App\Helper\CartHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();
dd($request->all());
        if($user){
            $cartItem = Cart::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            if($cartItem){
                $cartItem->increment($quantity);
            }else{
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => 1
                ]);
            }

        }else{
            $cartItems = CartHelper::getCookieCartItems();
            $isProductExist = false;
            foreach ($cartItems as $item){
                if($item['product_id'] == $product->id){
                    $item['quantity'] += $quantity;
                    $isProductExist = true;
                    break;
                }
            }
            if (!$isProductExist) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }
            CartHelper::setCookieCartItems($cartItems);
        }

//        return redirect()->back()->with('success', 'cart added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $quantity = $request->integer('quantity');
        $user = $request->user();

        if($user){
            Cart::query()->where(['user_id' => $user->id, 'product_id' => $product->id])
                ->update(['quantitry' => $quantity]);

        }else{
            $cartItems = CartHelper::getCookieCartItems();
            foreach ($cartItems as $item){
                if($item['product_id'] == $product->id){
                    $item['quantity'] = $quantity;
                    break;
                }
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();
        if($user){
            Cart::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first()?->delete();
            if(Cart::count() <= 0){
                return redirect()->route('user.home')->with('info', 'your cart is empty');
            }else{
                return redirect()->back()->with('success', 'item removed succesfully');
            }
        }else{
            $cartItems = Cart::getCookieCartItems();
            foreach ($cartItems as $i => &$item) {
                if ($item['product_id'] === $product->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            CartHelper::setCookieCartItems($cartItems);
            if (count($cartItems) <= 0) {
                return redirect()->route('user.home')->with('info', 'your cart is empty');
            } else {
                return redirect()->back()->with('success', 'item removed successfully');
            }
        }
    }
}
