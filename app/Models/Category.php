<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function parentcategory()
    {
        return $this->hasOne('App\Models\Category', 'id', 'parent_id')->select('id', 'category_name', 'url')->
        where('status', 1);
    }

    public function subcategories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id')->where('status', 1);
    }


    public static function getcategories()
    {
        return Category::with(['subcategories' => function($query) {
            $query->with('subcategories');
        }])->where('status', 1)->where('parent_id', 0)->get()->toArray();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'category_name',
        'category_discount',
        'desc',
        'url',
        'meta_desc',
        'meta_title',
        'meta_keywords',
        'status',
    ];
}
