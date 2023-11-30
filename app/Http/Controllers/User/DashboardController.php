<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Midtrans\Config;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('items', 'items.product')->latest()->paginate(10);

        return Inertia::render('User/Dashboard', [
            'orders' => $orders
        ]);
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
    public function store(Request $request)
    {
        $order = $request->order;

        $user = $request->user();
        $userAddress = UserAddress::where('user_id', $user->id)->where('isMain', 1)->first();
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order['order_id'],
                'gross_amount' => intval($order['total_price']),
            ),
            'customer_details' => array(
                'first_name' => 'Mr',
                'last_name' => $user->name,
                'email' => $user->email,
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return Inertia::render('User/Payment',[
            'order' => $order,
            'token' => $snapToken,
        ]);
    }

    public function response(Request $request){
        $server_key = env('MIDTRANS_SERVER_KEY');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$server_key);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'settlement'){
                $order = Order::with('items')->where('order_id',$request->order_id)->first();
                if($order){
                    foreach ($order->items as $item){
                        $product = Product::findOrFail($item->product_id);
                        $product->quantity -= $item->quantity;
                        $product->save();

                        if($product->quantity == 0){
                            $product->inStock = 0;
                            $product->save();
                        }
                    }
                }
                $order->status = 'Paid';
                $order->paid_at = $request->transaction_time;
                if($order->save()){
                    $payment = Payment::where('order_id', $order->id)->first();
                    $payment->status = 'Success';
                    $payment->save();
                }
            }
        }

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
