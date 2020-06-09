<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use App\Fun\__;
use App\Fun\Messages;

class RolesController extends Controller
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
        $query = Roles::select(
            'id',
            'name'
        )->where('del_flag', 0);
        $total = $query->count();
        $page_number = ceil($total/__::TAKE_ITEM);
        return view('roles.index', [
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
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->name)) {
            return redirect(route('roles.index'))->with([
                'message' => Messages::errors()->roles('name'),
                'error'   => true
            ]);
        } else {
            Roles::create([
                'name' => $request->name
            ]);
            return redirect(route('roles.index'))->with([
                'message' => Messages::success(),
                'error'   => false
            ]);
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
