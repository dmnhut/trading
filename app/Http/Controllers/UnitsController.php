<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Units;
use App\Fun\__;
use App\Fun\Messages;
use App\Fun\Validate;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = empty($request->page) ? 1 : $request->page;
        $query = Units::select(
            'id',
            'name'
        )->where('del_flag', 0)
         ->orderBy('name');
        $total = $query->count();
        $page_number = ceil($total/__::TAKE_ITEM);
        return view('units.index', [
            'data'        => $query->paginate(__::TAKE_ITEM),
            'page_number' => $page_number,
            'page_active' => $page
        ]);
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
        if (preg_match(Validate::reg('ALPHABET'), $request->name) || $request->name == null) {
            array_push($validate, Messages::errors()->units('name'));
        }
        if (empty($validate)) {
            Units::create([
                'name' => $request->name
            ]);
            return [
                'messages' => [Messages::success()],
                'error'    => false
            ];
        } else {
            return [
                'messages' => $validate,
                'error'    => true
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
        Units::find($id)
             ->update([
                 'del_flag' => 1,
                 DB::raw('version_no + 1')
             ]);
        return redirect(route('units.index'))->with([
            'message' => Messages::delete(),
            'error'   => false
        ]);
    }
}
