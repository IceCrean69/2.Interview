<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['brand_id', 'material_id', 'code', 'name', 'description', 'price'];

    public function brand()
    {
        return $this -> belongsTo(Brand :: class);
    }

    public function material()
    {
        return $this -> belongsTo(Material :: class);
    }
    
}
