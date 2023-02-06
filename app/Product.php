<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ["product_name","product_type_detail","length","height","width","available","price","description","product_url"];
    protected $table = "products";
    public $timestamps = true;
}
