<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Districts;

class DistrictController extends Controller
{
    /**
     * index
     *
     * @param  $request
     * @return Districts
     */
    public function index(Request $request)
    {
        return Districts::select('id as id', 'name as text')
                        ->where('id_province', $request->id)
                        ->orderBy('text')
                        ->get();
    }
}
