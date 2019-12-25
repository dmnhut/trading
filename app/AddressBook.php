<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    protected $table = 'addressbook';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';
    protected $fillable = [
     'id_user','id_province','id_district','id_ward','address','del_flag','version_no'
   ];
}
