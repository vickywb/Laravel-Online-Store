<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\PromotionCode;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {   
        //Save User Data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        //Process Checkout
        $code = 'STORE-' . mt_rand(0000, 9999);
        $carts = Cart::with(['product', 'user'])
            ->where('user_id', Auth::user()->id)
            ->get();
        
        //Transaction Create
        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'insurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_code' => $code,
            'transaction_status' => 'PENDING',
            'date_of_transaction' => Carbon::now()
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(0000, 9999);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'receipt_number' => '',
                'transaction_code' => $trx
            ]);
        }

        //Delete Cart Data
        Cart::where('user_id', auth()->user()->id)->delete();

        //Configuration Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //Create Array for Midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enable_payments' => [
                'gopay', 'permata_va', 'bank_transfer', 'credit_card'
            ],
            'vtweb' => []
        ];

        try {
        // Get Snap Payment Page URL
        $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
        // Redirect to Snap Payment Page
        return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function callback(Request $request)
    {
        //Set configuration midtrans
        Config::$serverKey      = config('services.midtrans.serverKey');
        Config::$isProduction   = config('services.midtrans.isProduction');
        Config::$isSanitized    = config('services.midtrans.isSanitized');
        Config::$is3ds          = config('services.midtrans.is3ds');

        //Instance notification midtrans
        $notification = new Notification();

        //Assign variable 
        $status     = $notification->transaction_status;
        $type       = $notification->payment_type;
        $fraud      = $notification->fraud_status;
        $order_id   = $notification->order_id;

        //Find Transaction id
        $transaction = Transaction::findOrFail($order_id);

        //Handle notification status
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->status = 'PENDING';
                } else {
                    $transaction->status = 'SUCCESS';
                }
            }
        }

        else if ($status == 'settlement') {
            $transaction->status = 'SUCCESS';
        }

        else if ($status == 'pending') {
            $transaction->status = 'PENDING';
        }

        else if ($status == 'deny') {
            $transaction->status = 'CANCELED';
        }

        else if ($status == 'expire') {
            $transaction->status = 'CANCELED';
        }

        else if ($status == 'cancel') {
            $transaction->status = 'CANCELED';
        }

        //Transaction Save
        $transaction->save();
    }

    // Transaction Code of Payment using Visa
    // Visa number : 4811 1111 1111 1114 
    // Expiry Month 01 (or any month)
    // Expiry Year 2025 (or any future year)
    // CVV: 123
    // OTP/3DS: 112233
}
