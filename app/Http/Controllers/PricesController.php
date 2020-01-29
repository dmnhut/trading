<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Prices;
use App\__;

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('prices.index', ['data' => Prices::select('id', 'kg', 'amount', 'turn_on')
                                                     ->where('del_flag', 0)
                                                     ->get()]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $model = Prices::find($request->id);
        if ($model->turn_on == 0) {
            $model->turn_on = 1;
        } else {
            $model->turn_on = 0;
        }
        $model->version_no = $model->version_no + 1;
        $model->save();
        return redirect(route('prices.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Prices::create([
          'kg' => $request->kg,
          'amount' => $request->amount
        ]);
        $data = Prices::select('id', 'kg', 'amount', 'turn_on')
                      ->where('del_flag', 0)
                      ->get();
        foreach ($data as $value) {
            $value->url = route('prices.destroy', [$value->id]);
        }
        return [
          'message' => __::messages()->success(),
          'data' => $data
        ];
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
        Prices::find($id)
              ->update(['del_flag' => 1, DB::raw('version_no + 1')]);
        return redirect(route('prices.index'));
    }
}
