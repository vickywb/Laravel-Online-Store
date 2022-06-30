<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionCode;
use App\Repositories\PromoCodeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionCodeController extends Controller
{   
    private $promotionCodeRepository;

    public function __construct(PromoCodeRepository $promotionCodeRepository)
    {
        $this->promotionCodeRepository = $promotionCodeRepository;
    }

    public function index()
    {   
        $promotionCodes = $this->promotionCodeRepository->get([
            'pagination' => 5,
            'order' => 'name ASC'
        ]);
        return view('admin.promocodes.index', [
            'promotionCodes' => $promotionCodes
        ]);
    }

    public function create()
    {
        $promotionCode = new PromotionCode();
        $typeMaps = PromotionCode::TYPE_MAP;

        return view('admin.promocodes.create', [
            'promotionCode' => $promotionCode,
            'typeMaps' => $typeMaps
        ]);
    }

    public function store(Request $request, PromotionCode $promotionCode)
    {
        $data = $request->only([
            'name', 'code', 'type', 'amount'
        ]);

        try {
            DB::beginTransaction();

            $promotionCode = new PromotionCode($data);
            $promotionCode = $this->promotionCodeRepository->store($promotionCode);

            DB::commit();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-promocode.index')->with([
            'success' => 'Promotion Code successfully created.'
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, PromotionCode $promotionCode)
    {
        return view('admin.promocodes.edit', [
            'promotionCode' => $promotionCode
        ]);
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
