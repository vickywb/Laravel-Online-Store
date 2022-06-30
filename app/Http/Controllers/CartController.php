<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\PromotionCode;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }
    
    public function index()
    {   
        $user = auth()->user()->id;

        $carts = $this->cartRepository->get([
            'with' => ['product.productImages', 'user'],
            'user_id' => $user
        ]);

        $promoCodes = PromotionCode::all();

        return view('pages.cart', [
        'carts' => $carts,
        'promoCodes' => $promoCodes
        ]);
    }

    public function success()
    {
        return view('pages.success');
    }

    public function delete(Request $request, Cart $cart)
    {
       try {
           DB::beginTransaction();

           $cart->delete();

           DB::commit();
       } catch (\Throwable $th) {
           DB::rollBack();
           
           return redirect()->back()->with([
            'errors' => $th->getMessage()
           ]);
       }
		return redirect()->route('cart')->with([
			'success' => 'Cart successfully deleted.'
		]);
    }
}
