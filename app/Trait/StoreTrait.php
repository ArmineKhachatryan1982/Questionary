<?php
namespace App\Trait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            return $this->base64($item->id,$file['path']);
        //   $path = FileUploadService::upload($request['photo'], $table_name . '/' . $item->id);
        //   $photoData = [
        //     'path' => $path,
        //     'name' => $photo->getClientOriginalName()
        //   ];

        //   $item->images()->create($photoData);
        }




        return true;
      }
    }
  }
  public function  base64($id,$path){

    $file = $path;
    // first explode as "," (data:image/jpeg;base64,)
$file_base_explode = explode(",",$file);

  // second we explode  as ";"(data:image/jpeg)
  $file_base_explode_first_argument = explode(";", $file_base_explode[0]);
  dd($file_base_explode[0]);
// third we explode  for geting  jpeg  extention
$extention=explode("/", $portfoliopic_base_explode_first_argument[0])[1];
// creating  $name for saving file  in database  in portfolio_pic column
$name = time().rand(1,100).'.'.$extention;
// via  file_put_contents  we save the data which is a data:image/jpeg;base64, and in the folder we save data via concating  name
dd($file_base_explode[1]);
file_put_contents('test/'.$id.'/'.$name, base64_decode($file_base_explode[1]));

    // $create_file=File::create([
    // 'executor_profile_id' => $executor_profiles->id,
    //     'portfolio_pic' => $name,
    //     'portfoliopic_base' => $items['portfoliopic_base']
    // ]);
  }




}
