<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPay extends Model
{
    protected $table = 'order_pay';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'id_order',
        'id_pay',
        'del_flag',
        'version_no'
    ];
}
