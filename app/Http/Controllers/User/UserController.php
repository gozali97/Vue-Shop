<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['category', 'brand', 'product_images'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->OrWhere('description', 'like', '%' . $search . '%')
                    ->OrWhere('price', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();
        return Inertia::render('User/Index',[
            'products' => $products,
            'search' => $request->search
        ]);
    }

    public function about()
    {
        return Inertia::render('User/About');
    }

    public function contact()
    {
        return Inertia::render('User/Contact');
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
        //
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
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
