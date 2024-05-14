<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id')->with('parentcategory');
    }

    public static function filterProducts()
    {
        $filterProducts['fabricArray'] = array('Cotton', 'Wool', 'Polyester');
        $filterProducts['sleeveArray'] = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $filterProducts['patternArray'] = array('Checked', 'Plain', 'Printed');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function attributes()
    {
        return $this->hasMany('App\Models\ProductAttributes');
    }

}
