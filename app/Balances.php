<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balances extends Model
{
    protected $table = 'balances';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'id_shipper',
        'total',
        'del_flag',
        'version_no'
    ];
}
