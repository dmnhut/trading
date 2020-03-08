<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wards;

class WardController extends Controller
{
    /**
     * index
     *
     * @param  $request
     * @return Wards
     */
    public function index(Request $request)
    {
        return Wards::select('id as id', 'name as text')
                    ->where('id_district', $request->id)
                    ->orderBy('text')
                    ->get();
    }
}
