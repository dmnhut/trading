<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusUser extends Model
{
    protected $table = 'status_user';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'id_status',
        'id_user',
        'del_flag',
        'version_no'
    ];
}
