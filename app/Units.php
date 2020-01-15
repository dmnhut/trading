<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $table = 'units';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'id','name','del_flag','version_no'
    ];
}
