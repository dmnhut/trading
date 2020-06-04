<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class __ extends Controller
{
    /**
     * getTables
     *
     * @return collect
     */
    public function getTables()
    {
        $table_names = [
            'addressbook',
            'balance_log',
            'balances',
            'detail_shipper',
            'districts',
            'geolocation',
            'order_confirm',
            'order_detail',
            'order_pay',
            'order_price',
            'order_unit',
            'orders',
            'pays',
            'prices',
            'provinces',
            'role_user',
            'roles',
            'status',
            'status_order',
            'status_user',
            'traces',
            'traces_log',
            'units'
        ];
        $data = collect([]);
        foreach ($table_names as $table_name) {
            $columns = collect([]);
            $column_names = DB::select("select column_name as name
                                          from information_schema.columns
                                         where table_name = :table_name", [
                                             'table_name' => $table_name
                                         ]);
            foreach ($column_names as $column_name) {
                $columns->push($column_name->name);
            }
            $data->put($table_name, $columns);
        }
        return $data;
    }
}
