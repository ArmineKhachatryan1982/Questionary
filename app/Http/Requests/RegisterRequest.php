<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Request;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $array=[];
        $array['password']='required|min:6|max:8';

        if(!$this->nickname_or_email|| $this->nickname_or_email==null){

            $array['nickname_or_email']='required';
        }else{

        if (filter_var($this->nickname_or_email, FILTER_VALIDATE_EMAIL)) {
            // Check for unique email
            $array['nickname_or_email']='unique:users,email';

        }else{
            $array['nickname_or_email']='unique:users,nickname';

        }
    }


        return $array;


    }
    public function messages(): array
    {
        return [

        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); // Here is your array of errors

        throw new HttpResponseException(response()->json(['errors'=>$errors],422));

    }
}
