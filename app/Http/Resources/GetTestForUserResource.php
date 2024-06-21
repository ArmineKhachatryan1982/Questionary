<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetTestForUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

        "id" => $this->id,
        "category_id" => $this->category_id,
        "category_name"=>$this->categories->translation(app()->getLocale())->text,
        "name" => $this->name,
        "time_in_seconds" => $this->time_in_seconds,
        "question_count" => $this->question_count,
        "answer_type_id" => $this->answer_type_id,
        "answer_type_name" =>$this->answer_types->translation(app()->getLocale())->text,
        "questions"=>QuestionResource::collection($this->questions)
        ];
    }
}
