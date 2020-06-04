<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderUnit extends Model
{
    protected $table = 'order_unit';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'id_item',
        'id_unit',
        'del_flag',
        'version_no'
    ];
}
