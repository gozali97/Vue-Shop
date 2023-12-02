<?php

namespace App\Http\Middleware;

use App\Helper\CartHelper;
use App\Http\Resources\CartResource;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;


class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $bannerGlobal = Banner::where('isActive', 1)->get();
        $categoryGlobal = Category::all();
        $brandGlobal = Brand::all();

        $cartBelongsToRequestUser = 0;
        if ($request->user()) {
            $cartBelongsToRequestUser = Cart::whereUserId($request->user()->id)->whereNull('paid_at')->count();
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'cart' => new CartResource(CartHelper::getProductsAndCartItems()),
            'carts_global_count' => $request->user() ? Cache::rememberForever('carts_global_count', fn () => $cartBelongsToRequestUser) : '',
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info')
            ],
            'banner_global' => cache()->rememberForever('banner_global', fn () => $bannerGlobal),
            'category_global' => cache()->rememberForever('category_global', fn () => $categoryGlobal),
            'brand_global' => cache()->rememberForever('brand_global', fn () => $brandGlobal),
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ];
    }
}
