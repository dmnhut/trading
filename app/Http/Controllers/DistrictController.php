<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Districts;

class DistrictController extends Controller
{
  public function index(Request $request)
  {
      $data = Districts::select('id as id', 'name as text')->where('id_province', $request->id)->orderBy('text')->get();
      return $data;
  }
}
