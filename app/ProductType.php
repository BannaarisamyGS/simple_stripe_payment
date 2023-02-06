<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    //
    public $fillable = ["product_type_name"];
    public $table = "product_type_list";
    public $timestamps = false;
}
