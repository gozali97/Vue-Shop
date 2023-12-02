<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = $request->user()->id;
        $address  = UserAddress::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where('type', 'like', '%' . $search . '%')
                    ->OrWhere('province', 'like', '%' . $search . '%')
                    ->OrWhere('address1', 'like', '%' . $search . '%')
                    ->OrWhere('no_hp', 'like', '%' . $search . '%')
                    ->OrWhere('city', 'like', '%' . $search . '%');
            })
            ->where('user_id', $id)
            ->paginate(10)->withQueryString();

        $con =  Http::withHeaders([
            'key' => '067f3c3070f9ba9652054f7f1eb0e182',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('https://api.rajaongkir.com/starter/province');
        $provinces = $con['rajaongkir']['results'];



        return Inertia::render('User/UserAddress/Index',[
            'address' => $address,
            'provinces' => $provinces,
        ]);
    }

    public function getCity($id)
    {
        $response = Http::withHeaders([
            'key' => '067f3c3070f9ba9652054f7f1eb0e182',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('https://api.rajaongkir.com/starter/city?province=' . $id);

        $dataCities = $response['rajaongkir']['results'];

        return response()->json(['data' => $dataCities]);
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

        $address = new UserAddress;
        $address->type = $request->type;
        $address->address1 = $request->address1;
        $address->no_hp = $request->no_hp;
        $address->isMain = $request->isMain;
        $address->postcode = $request->postcode;
        $address->country_code = $request->country_code;
        $address->city_id = $request->city_id;
        $address->prov_id = $request->prov_id;
        $address->user_id = $request->user()->id;

        $response = Http::withHeaders([
            'key' => '067f3c3070f9ba9652054f7f1eb0e182',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('https://api.rajaongkir.com/starter/city?id='.$request->city_id.'&province='.$request->prov_id);

        $data = $response['rajaongkir']['results'];

        $address->province = $data['province'];
        $address->city = $data['city_name'];

        if ($address->save()){
            return redirect()->route('address')->with('success', 'Address created successfully.');
        }else{
            return redirect()->back()->with('errors', 'Failed create address');
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
    public function update(Request $request, $id)
    {
        $address = UserAddress::findOrFail($id);
        $address->type = $request->type;
        $address->address1 = $request->address1;
        $address->no_hp = $request->no_hp;
        $address->isMain = $request->isMain;
        $address->postcode = $request->postcode;
        $address->country_code = $request->country_code;
        $address->city_id = $request->city_id;
        $address->prov_id = $request->prov_id;
        $address->user_id = $request->user()->id;

        $response = Http::withHeaders([
            'key' => '067f3c3070f9ba9652054f7f1eb0e182',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('https://api.rajaongkir.com/starter/city?id='.$request->city_id.'&province='.$request->prov_id);

        $data = $response['rajaongkir']['results'];

        $address->province = $data['province'];
        $address->city = $data['city_name'];

        if ($address->save()){
            return redirect()->route('address')->with('success', 'Address updated successfully.');
        }else{
            return redirect()->back()->with('errors', 'Failed create address');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $address = UserAddress::findOrFail($id);
        if($address){
            $address->delete();
        }
        return redirect()->route('address')->with('success', 'Address deleted successfully.');
    }
}
