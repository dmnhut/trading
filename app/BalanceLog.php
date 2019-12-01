<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BalanceLog extends Model
{
    protected $table = 'balance_log';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
      'id_order','id_user','id_shipper','amount','pay_shipper','note','del_flag'
    ];
}
