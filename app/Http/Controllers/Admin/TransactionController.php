<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{   
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        $transactions = $this->transactionRepository->get([
            'with' => ['user'],
            'pagination' => 5,
            'order' => 'created_at DESC'
        ]);

        return view('admin.transactions.index', [
            'transactions' => $transactions
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit(Transaction $transaction)
    {   
        $transaction = Transaction::findOrFail($transaction->id);
        $transactionStatuses = Transaction::STATUS_MAP;

        return view('admin.transactions.edit', [
            'transaction' => $transaction,
            'transactionStatuses' => $transactionStatuses
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->only([
            'transaction_status', 'total_price'
        ]);

        try {
            DB::beginTransaction();

            $transaction->update($data);
 
            DB::commit();
         } catch (\Throwable $th) {
            DB::rollBack();
 
            return redirect()->back()->withErrors([
             'errors' => $th->getMessage()
            ]);
         }

        return redirect()->route('admin-transaction.index')->with([
            'message' => 'Transaction successfully updated.'
        ]);
    }

    public function destroy(Transaction $transaction)
    {
        try {
           DB::beginTransaction();
            
            $transaction->delete();

           DB::commit();
        } catch (\Throwable $th) {
           DB::rollBack();

           return redirect()->back()->withErrors([
            'errors' => $th->getMessage()
           ]);
        }

        return redirect()->route('admin-transaction.index')->with([
            'message' => 'Transaction successfully deleted.'
        ]);
    }
}
