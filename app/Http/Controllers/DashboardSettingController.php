<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardSettingController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $categories = Category::all();

        return view('pages.dashboard-settings', [
            'user' => $user,
            'categories' => $categories
        ]);
    }

    public function account()
    {   
        $user = auth()->user();
        return view('pages.dashboard-account', [
            'user' => $user
        ]);
    }

    public function updateStore(Request $request, $redirect)
    {   
        $data = $request->merge([
            'store_name' => Str::slug($request->store_name)
        ]);

        $data = $request->only([
          'category_id', 'store_name', 'store_status'
        ]);

        $user = Auth::user();

        try {
            DB::beginTransaction();

            $user->profile->update($data);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route($redirect)->with([
            'message' => 'Store setting successfully updated'
        ]);
    }  
    
    public function updateAccount(Request $request, $redirect)
    {   
        $user = auth()->user();

        $data = $request->only([
            'name', 'email', 'user_id', 'address', 'address2', 'provinces_id',
            'regencies_id', 'post_code', 'country', 'phone_number'
        ]);

        try {
            DB::beginTransaction();

            $user->update($data);
            $user->profile->update($data);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route($redirect)->with([
            'message' => 'Your Account successfully updated'
        ]);
    }

}
