<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestGradeType;
use Exception;
use Illuminate\Http\Request;

class UserPastedTestController extends BaseController
{
    public function __invoke(Request $request){
        try{

            $test = Test::where('link',$request['test_link'])->first();
            $question = Question::where('test_id',$test->id)->with('answer_options')->get();
            $count = 0;
            $get_results = $request['question'];

            $trueAnswerOptions = array_map(function($item) {
                return $item['true_answer_option'];
            }, $get_results);


            $flattenedOptions = array_merge(...$trueAnswerOptions);

            $total = AnswerOption::whereIn('id',$flattenedOptions)->sum('mark');


            $test_grade_type = TestGradeType::where('test_id',60)->whereRaw('? BETWEEN low_grade AND high_grade', [$total])->first();

            if($test_grade_type!=null){

                return $this->sendResponse($test_grade_type->description,'success');

            }else{

                return $this->sendError('No matches found','success');
            }
        }catch (Exception $e){

            return response()->json(['error' =>$e->getMessage()], 500);

        }


    }
}
