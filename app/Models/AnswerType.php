<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerType extends Model
{
    use HasFactory;

    public function translation($lang){

        return $this->hasOne(AnswerTypeTranslation::class)->where('lang', $lang)->first();
     }
}
