<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pays;
use App\Fun\__;
use App\Fun\Messages;

class PaysController extends Controller
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
        $query = Pays::select(
            'id',
            'percent',
            'turn_on'
        )->where('del_flag', 0);
        $total = $query->count();
        $page_number = ceil($total/__::TAKE_ITEM);
        return view('pays.index', [
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
        return view('pays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->percent)) {
            return redirect(route('pays.index'))->with([
                'message' => Messages::errors()->pays('percent.require'),
                'error'   => true
            ]);
        } else {
            $percent = Pays::where('percent', $request->percent)
                           ->get();
            if ($percent->isEmpty()) {
                Pays::create([
                    'percent' => $request->percent
                ]);
                return redirect(route('pays.index'))->with([
                    'message' => Messages::success(),
                    'error'   => false
                ]);
            } else {
                return redirect(route('pays.index'))->with([
                    'message' => Messages::errors()->pays('percent.unique'),
                    'error'   => true
                ]);
            }
        }
    }

    /**
     * status
     *
     * @param  Request
     * @return redirect
     */
    public function status(Request $request)
    {
        $count = Pays::count();
        $model = Pays::find($request->id);
        if ($count == 1 && $model->turn_on == 1) {
            return redirect(route('pays.index'));
        }
        $model->version_no = $model->version_no + 1;
        $model->turn_on = 1;
        $model->save();
        Pays::where('id', '<>', $request->id)
            ->update([
                'turn_on'    => 0,
                'version_no' => DB::raw('version_no + 1')
            ]);
        return redirect(route('pays.index'))->with([
            'message' => Messages::status(),
            'error'   => false
        ]);
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
        $model = Pays::find($id);
        if ($model->turn_on == 1) {
            return redirect(route('pays.index'))->with([
                'message' => Messages::errors()->pays('percent.use'),
                'error'   => true
            ]);
        } else {
            $model->del_flag = 1;
            $model->version_no = $model->version_no + 1;
            $model->save();
            return redirect(route('pays.index'))->with([
                'message' => Messages::delete(),
                'error'   => false
            ]);
        }
    }
}
