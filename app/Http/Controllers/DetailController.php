<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{   
    private $productRepository;
    private $cartRepository;

    public function __construct(
    ProductRepository $productRepository, 
    CartRepository $cartRepository)
    {
        $this->productRepository = $productRepository; 
        $this->cartRepository = $cartRepository;   
    }
    public function index(Request $request, $id)
    {   
        $product = Product::with('productImages', 'user')->where('slug', $id)->firstOrFail();

        return view('pages.detail', [
            'product' => $product
        ]);
    }

    public function add(Request $request, Product $product)
    {   
        $user  = auth()->user();

        $data = [
            'product_id' => $product->id,
            'user_id' => $user->id
        ];

        try {
            DB::beginTransaction();

            $cart = new Cart($data);
            $cart = $this->cartRepository->store($cart);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('cart');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
