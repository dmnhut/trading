<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'code','id_user','id_shipper','id_province','id_district','id_ward','total_amount','address','receiver','phone','note','del_flag','version_no'
    ];
}
