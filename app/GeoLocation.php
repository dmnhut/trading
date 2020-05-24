<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeoLocation extends Model
{
    protected $table = 'geolocation';
    protected $primaryKey = 'id';
    protected $keyType = 'varchar';
    protected $fillable = [
      'id_user', 'id_order', 'lat', 'lng', 'datetime', 'del_flag', 'version_no'
    ];
}
