<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;

class LocationController extends Controller{

    public function indexProvinces(Request $request)
    {
        return Province::all();
    }

    public function indexRegencies(Request $request, $provinces_id)
    {   
        return Regency::where('province_id', $provinces_id)->get();
    }
}