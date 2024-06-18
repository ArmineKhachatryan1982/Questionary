<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class RegisterController extends BaseController
{
    public function __invoke(RegisterRequest $request){

        $data=[];


            if (filter_var($request['nickname_or_email'], FILTER_VALIDATE_EMAIL)) {
                // Check for unique email
                if (User::where('email', $request['nickname_or_email'])->exists()) {
                    // return response()->json('The email has already been taken.');
                    return $this->sendError('The email has already been taken.');
                }else{
                    $data['email'] = $request['nickname_or_email'];
                }
            }else{
                if (User::where('nickname', $request['nickname_or_email'])->exists()) {

                    return $this->sendError('The nickname has already been taken.');
                }else{
                    $data['nickname']=$request['nickname_or_email'];
                }

            }

            $data['password']=$request['password'];

// dd($data);
        $user = User::create($data);
        return $this->sendResponse(new UserResource($user),'success');

    }






}
