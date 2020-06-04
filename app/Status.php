<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'name',
        'del_flag',
        'version_no'
    ];
}
