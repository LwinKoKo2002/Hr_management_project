<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
        $employee_id = $this->route('employee');
        return [
            'employee_id'=>['required',Rule::unique('users', 'employee_id')->ignore($employee_id)],
            'name'=>['required','min:3','max:20'],
            'email'=>['required','email',Rule::unique('users', 'email')->ignore($employee_id)],
            'phone'=>['required','min:9','max:11',Rule::unique('users', 'phone')->ignore($employee_id)],
            'password'=>['required','min:8','max:20'],
            'pin_code'=>['min:6','max:6',Rule::unique('users', 'pin_code')->ignore($employee_id)],
            'department_id'=>['required',Rule::exists('departments', 'id')],
            'profile_img'=>[Rule::unique('users', 'profile_img')],
            'address'=>['required','min:6'],
            'nrc_number'=>['required'],
            'birthday'=>['required','date'],
            'gender'=>['required'],
            'is_present'=>['required'],
            'date_of_join'=>['required','date']
        ];
    }
}
