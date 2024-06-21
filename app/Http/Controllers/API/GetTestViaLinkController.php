<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetTestForUserResource;
use App\Models\Test;
use Illuminate\Http\Request;

class GetTestViaLinkController extends BaseController
{
    public function __invoke($link){

        $test = Test::where('link',$link)->first();

        return $this->sendResponse(new GetTestForUserResource($test),'success');
    }
}
