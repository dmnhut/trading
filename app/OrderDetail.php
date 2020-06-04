<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'id_order',
        'item_name',
        'path',
        'quantity',
        'content',
        'del_flag',
        'version_no'
    ];
}
