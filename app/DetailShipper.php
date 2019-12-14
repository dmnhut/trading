<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailShipper extends Model
{
    protected $table = 'detail_shipper';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'id_user','id_province','id_district','id_ward','del_flag'
    ];
}
