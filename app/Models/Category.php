<?php

namespace App\Models;

use App\Trait\GetCategoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,GetCategoryTrait;
    public function category_translations(){
        return $this->hasMany(CategoryTranslation::class);
    }
    public function translation($lang){

        return $this->hasOne(CategoryTranslation::class)->where('lang', $lang)->first();
     }
   
     public function tests(){

        return $this->hasMany(Test::class);
     }

}
