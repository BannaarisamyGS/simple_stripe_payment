<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddresses extends Model
{
    //
    protected $fillable = ["user_id","line1","line2","city","country","postal_code","state"];
    protected $table="user_addresses";
    public $timestamps = false;
}
