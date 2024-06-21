<?php
namespace App\Trait;

use App\Models\AnswerOption;
use App\Models\File;
use App\Models\Question;
use App\Models\TestGradeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StoreTrait{

    abstract function model();
  public function itemStore(Request $request)
  {
    // dd(Auth()->user());
// dd($request->all());

    $data = $request->except(['file','grade_type', 'question']);
    $data['user_id'] = Auth()->id();
// dd($data);
    $className = $this->model();
// dd($className);
    if (class_exists($className)) {

      $model = new $className;
      $relation_foreign_key = $model->getForeignKey();
    //   dd($relation_foreign_key);
      $table_name = $model->getTable();

      $item = $model::create($data);

      if ($item) {

        if ($file = $request['file'] ?? null) {

            $convert_image = $this->base64($item->id,$file['path']);

            if($convert_image==false){

              return false;

            }

        //   $path = FileUploadService::upload($request['photo'], $table_name . '/' . $item->id);
                $create_file=File::create([
                    'test_id' => $item->id,
                    'name' => $convert_image['name'],
                    'path' => 'public/'.$convert_image['path'],
                ]);

        }

        if($request['grade_type']){

            $this->grade_type($item->id,$request['grade_type']);

        }
        if($request['question']){
            $this->question($item->id,$request['question']);
        }

        $link_code = Str::random(10);
        $item ->link = $link_code;
        $item->save();
        $returned_link = env('APP_URL')."/test/".$link_code;

         return $returned_link;

      }
    }
  }
  public function  base64($id, $file){


    // first explode as "," (data:image/jpeg;base64,)
$file_base_explode = explode(",",$file);

  // second we explode  as ";"(data:image/jpeg)
  $file_base_explode_first_argument = explode(";", $file_base_explode[0]);
//   dd($file_base_explode[0]);
// third we explode  for geting  jpeg  extention

$extention=explode("/", $file_base_explode_first_argument[0])[1];
if(in_array($extention, ['jpeg','jpg','png']))
{



// creating  $name for saving file  in database  in portfolio_pic column
$name = time().rand(1,100).'.'.$extention;
// via  file_put_contents  we save the data which is a data:image/jpeg;base64, and in the folder we save data via concating  name
// dd(base64_decode($file_base_explode[1]));
$path='test/'.$id.'/'.$name;

$image_file = base64_decode($file_base_explode[1]);
// file_put_contents('test/'.$id.'/'.$name, base64_decode($file_base_explode[1]));
    Storage::disk('local')->put($path,$image_file);
    $file_path_array=[];
    $file_path_array['name'] = $name;
    $file_path_array['path'] = $path;
    $file_path_array['image_file'] = $image_file;

    return $file_path_array;

  }else{

    return false;

  }


  }
  public function grade_type($test_id,$grade_type){

    foreach($grade_type as $item){
         $item['test_id'] = $test_id;
        $test_grade_type = TestGradeType::create($item);

    }
    return true;

  }
  public function question($test_id,$questions){

    foreach($questions as $question){

        $question['test_id'] = $test_id;

        $data = array_diff_key($question, array_flip(['answer_option']));;

        $create_question = Question::create($data);
        if($create_question){

            foreach($question['answer_option'] as $option){
                $option['question_id'] = $create_question->id;
                $answer_option = AnswerOption::create( $option);

            }
        }


    }
        return true;
  }




}
