<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pays;
use App\__;

class PaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pays.index', ['data' => Pays::select('id', 'percent', 'turn_on')->where('del_flag', 0)->get()]);
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
              'message' => 'Phần trăm không được rỗng',
              'error' => true
            ]);
        } else {
            Pays::create([
              'percent' => $request->percent
            ]);
            return redirect(route('pays.index'))->with([
              'message' => 'Thêm mới thành công',
              'error' => false
            ]);
        }
    }

    /**
     * [status description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function status(Request $request)
    {
        $count = Pays::count();
        $model = Pays::find($request->id);
        if ($count == 1 && $model->turn_on == 1) {
            return redirect(route('pays.index'));
        }
        $model->turn_on = 1;
        $model->save();
        Pays::where('id', '<>', $request->id)
            ->update([
                  'turn_on' => 0
              ]);
        return redirect(route('pays.index'))->with([
          'message' => 'Đã thay đổi trạng thái',
          'error' => false
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
        $model->del_flag = 1;
        $model->save();
        return redirect(route('pays.index'))->with([
          'message' => 'Đã xóa thành công',
          'error' => false
        ]);
    }
}
