<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $table = 'provinces';
    protected $primaryKey = 'id';
    protected $keyType = 'varchar';
    protected $fillable = [
        'name',
        'del_flag',
        'version_no'
    ];
}
