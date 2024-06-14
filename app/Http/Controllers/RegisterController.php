<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    public function __invoke(RegisterRequest $request){
        // dd($request->all());
        $user = User::create($request->all());
        return $this->sendResponse(new UserResource($user),'success');

    }
}
