<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductTableResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $products = Product::query()
            ->with(['category', 'brand'])
            ->when($request->q, function ($query, $q){
                $query->where('title', 'like', '%'.$q.'%');
            })
            ->latest()
            ->paginate(10);
        $brands = Brand::all();
        $categories = Category::all();

        return Inertia::render('Admin/Product/Index',[
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
            'search'=> $request->q
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
        $product = new Product;
        $product->title = $title = $request->title;
        $product->slug = str($title)->slug();
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if($product->save()){
            //check if product has images upload

            if ($request->hasFile('product_images')) {
                $productImages = $request->file('product_images');
                foreach ($productImages as $image) {
                    // Generate a unique name for the image using timestamp and random string
                    $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    // Store the image in the public folder with the unique name
                    $image->move('product_images', $uniqueName);
                    // Create a new product image record with the product_id and unique name
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'product_images/' . $uniqueName,
                    ]);
                }
            }

            return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
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
