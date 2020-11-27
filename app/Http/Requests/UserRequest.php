<?php

namespace App\Http\Requests;

use App\Rules\BirthDate;
use App\Rules\Username;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => ['required', 'alpha'],
            'middle_name' => ['required', 'alpha'],
            'last_name' => ['required', 'alpha'],
            'username' => ['required', 'string', new Username],
            'date_of_birth' => ['required', 'string', new BirthDate]
        ];
    }
}
