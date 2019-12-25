<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    protected $table = 'wards';
    protected $primaryKey = 'id';
    protected $keyType = 'varchar';
    protected $fillable = [
      'name','id_district','del_flag','version_no'
    ];
}
