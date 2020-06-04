<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TracesLog extends Model
{
    protected $table = 'traces_log';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
        'id_trace',
        'id_status',
        'time',
        'note',
        'del_flag',
        'version_no'
    ];
}
