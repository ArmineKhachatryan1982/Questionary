<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function categories(){
        return $this->belongsTo(Category::class,'category_id');

    }
    public function answer_types(){
        return $this->belongsTo(AnswerType::class,'answer_type_id');

    }
    public function questions(){
        return $this->hasMany(Question::class);
    }
}
