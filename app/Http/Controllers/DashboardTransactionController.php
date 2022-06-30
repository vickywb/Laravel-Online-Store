<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $sellTransactions = TransactionDetail::with(['transaction.user', 'product.productImages'])
            ->whereHas('product', function($product) {
                $product->where('user_id', auth()->user()->id);
            })
            ->get();
        
        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.productImages'])
            ->whereHas('transaction', function($transaction) {
                $transaction->where('user_id', auth()->user()->id);
            })
            ->get();

        return view('pages.dashboard-transactions', [
            'sellTransactions' => $sellTransactions,
            'buyTransactions' => $buyTransactions
        ]);
    }

    public function details(Request $request, $id)
    {   
        $transaction = TransactionDetail::with(['transaction.user', 'product.productImages'])
            ->findOrFail($id);

        return view('pages.dashboard-transactions-details', [
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, TransactionDetail $transactionDetail)
    {
        $data = $request->only([
            'shipping_status', 'receipt_number'
        ]);

        try {
            DB::beginTransaction();

            $transactionDetail->update($data);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('dashboard-transactions-details', $transactionDetail)->with([
            'success' => 'Transaction details successfully updated'
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
