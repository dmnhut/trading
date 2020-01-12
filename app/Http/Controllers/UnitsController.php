<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Units;
use App\__;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Units::select('id', 'name')->where('del_flag', 0)->orderBy('name')->get();
        return view('units.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = [];
        if (preg_match(__::re('ALPHABET'), $request->name) || $request->name == null) {
            array_push($validate, __::messages()->errors()->units('name'));
        }
        if (empty($validate)) {
            Units::create([
          'name' => $request->name
        ]);
            return [
          'messages' => [__::messages()->success()],
          'error' => false
        ];
        } else {
            return [
            'messages' => $validate,
            'error' => true
          ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
