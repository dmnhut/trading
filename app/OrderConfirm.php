<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderConfirm extends Model
{
    protected $table = 'order_confirm';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'id_order',
        'id_shipper',
        'path',
        'del_flag',
        'version_no'
    ];
}
