<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    protected $table = 'prices';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'kg',
        'amount',
        'turn_on',
        'del_flag',
        'version_no'
    ];
}
