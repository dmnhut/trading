<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPrice extends Model
{
    protected $table = 'order_price';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'id_order', 'id_price','del_flag','version_no'
    ];
}
