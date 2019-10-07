<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traces extends Model
{
    protected $table = 'traces';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'id_order','id_status','time','note'
    ];
}
