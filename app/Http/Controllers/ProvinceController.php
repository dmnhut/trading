<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provinces;

class ProvinceController extends Controller
{
    /**
     * index
     *
     * @return Provinces
     */
    public function index()
    {
        return Provinces::select(
            'id as id',
            'name as text'
        )->orderBy('text')
         ->get();
    }
}
