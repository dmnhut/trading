<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balances extends Model
{
    protected $table = 'balances';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'id_user','amount','del_flag'
    ];
}
