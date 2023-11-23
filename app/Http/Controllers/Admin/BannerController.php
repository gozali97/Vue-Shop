<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $banners = Banner::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Admin/Banner/Index',[
            'banners' => $banners,
            'search'=> $request->search
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
        dd($request->all());
        $banner = new Banner;
        $banner->name = $title = $request->name;
        $banner->slug = str($title)->slug();
        $banner->isActive = $request->isActive;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Generate a unique name for the image using timestamp and random string
            $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            // Store the image in the public folder with the unique name
            $image->move('product_images', $uniqueName);
            // Create a new product image record with the product_id and unique name
            $banner->image = 'banner_image/' . $uniqueName;
        }
        if($banner->save()){
            //check if product has images upload
            return redirect()->route('admin.banner.index')->with('success', 'Product banner successfully.');
        }else{
            return redirect()->back()->with('errors', 'Failed create product');
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
