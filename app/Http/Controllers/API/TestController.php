<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Trait\StoreTrait;
use Illuminate\Http\Request;

class TestController extends BaseController
{
    use StoreTrait;
    public function model()
    {
      return Test::class;
    }

    public function __invoke(Request $request){

        $test = $this->itemStore($request);
        if($test==false){

            return $this->sendError('Upload right format file','success');

        }
        else{

            $returned_link = $test;

            return $this->sendResponse($returned_link,'success');
        }

    }
}
