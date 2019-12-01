<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'name','del_flag'
    ];
}
