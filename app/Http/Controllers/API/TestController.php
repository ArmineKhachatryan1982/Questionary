<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Trait\StoreTrait;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use StoreTrait;
    public function model()
    {
      return Test::class;
    }

    public function __invoke(Request $request){
     
        $test = $this->itemStore($request);

        if($test){

          return redirect()->route('product_list');
        }

    }
}
