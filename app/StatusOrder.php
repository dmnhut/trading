<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    protected $table = 'status_order';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'id_status','id_order'
    ];
}
