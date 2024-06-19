<?php
namespace App\Trait;

use App\Models\Category;

trait GetCategoryTrait{
    public function scopegetCategory(){
        $category=Category::all();
        return $category;
    }

}
