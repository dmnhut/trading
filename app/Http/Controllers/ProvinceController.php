<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provinces;

class ProvinceController extends Controller
{
    public function index()
    {
        $data = Provinces::select('id as id', 'name as text')->orderBy('text')->get();
        return $data;
    }
}
