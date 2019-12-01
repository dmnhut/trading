<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $table = 'districts';
    protected $primaryKey = 'id';
    protected $keyType = 'varchar';
    protected $fillable = [
      'name','id_province','del_flag'
    ];
}
