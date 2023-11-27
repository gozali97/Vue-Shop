<?php

namespace App\Http\Controllers\User;

use App\Helper\CartHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

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

        if($user){
            $cartItem = Cart::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            if($cartItem){
                $cartItem->quantity += 1;
                $cartItem->save();
            }else{
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => 1
                ]);
            }
            Cache::forget('carts_global_count');
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
    public function show(Request $request, Product $product)
    {
        $user = $request->user();
        if($user){
            $carts = Cart::with('product', 'product_image')->where('user_id', $user->id)->get();
            $userAddress = UserAddress::where('user_id', $user->id)->where('isMain', 1)->first();
            $count = Cart::where('user_id', $user->id)->count();
            $total = 0;

            if ($carts->count() != 0){
                foreach ($carts as $cart){
                    $item = Product::find($cart->product_id);
                    $sum = $item->price * $cart->quantity;
                    $total += $sum;
                }

                if($cart->count() > 0) {
                    return Inertia::render('User/CartList', [
                        'carts' => $carts,
                        'count' => $count,
                        'total' => $total,
                        'userAddress' => $userAddress
                    ]);
                }else {
                    return redirect()->back()->with('errors', 'You dont have product in cart');
                }
            }else{
                return Inertia::render('User/CartList', [
                    'userAddress' => $userAddress
                ]);
            }
        }else{
            $cart = CartHelper::getCookieCartItems();
            if(count($cart) > 0){
                $cart = new CartResource(CartHelper::getProductsAndCartItems());
                return Inertia::render('User/CartList',[
                    'cart' => $cart,
                ]);
            }else{
                return redirect()->back()->with('errors', 'You dont have product in cart');
            }
        }

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
                ->update(['quantity' => $quantity]);

        }else{
            $cartItems = CartHelper::getCookieCartItems();
            foreach ($cartItems as $item){
                if($item['product_id'] == $product->id){
                    $item['quantity'] = $quantity;
                    break;
                }
            }
        }
        Cache::forget('carts_global_count');
        return redirect()->back()->with('success', 'Success add quantity');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();
        if($user){
            Cart::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first()?->delete();
            Cache::forget('carts_global_count');
            if(Cart::count() <= 0){
                return redirect()->route('home')->with('info', 'your cart is empty');
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
                return redirect()->route('home')->with('info', 'your cart is empty');
            } else {
                return redirect()->back()->with('success', 'item removed successfully');
            }
        }
    }
}
