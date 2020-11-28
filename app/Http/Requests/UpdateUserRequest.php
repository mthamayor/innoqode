<?php

namespace App\Http\Requests;

use App\Rules\BirthDate;
use App\Rules\Username;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['alpha', 'required_without_all:middle_name,last_name,username,date_of_birth'],
            'middle_name' => ['alpha', 'required_without_all:first_name,last_name,username,date_of_birth'],
            'last_name' => [
                'alpha',
                'required_without_all:middle_name,first_name,username,date_of_birth'
            ],
            'username' => [
                'string',
                'required_without_all:middle_name,last_name,first_name,date_of_birth',
                new Username
            ],
            'date_of_birth' => [
                'string',
                'required_without_all:middle_name,last_name,username,first_name',
                new BirthDate
            ]
        ];
    }
}
