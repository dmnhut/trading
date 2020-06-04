<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $table = 'pays';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'percent',
        'turn_on',
        'del_flag',
        'version_no'
    ];
}
