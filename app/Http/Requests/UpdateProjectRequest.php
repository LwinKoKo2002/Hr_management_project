<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'title'=>['required','min:3'],
            'description'=>['required'],
            'start_date'=>['required'],
            'dead_line'=>['required'],
            'priority_id'=>['required',Rule::exists('priorities', 'id')],
            'status_id'=>['required',Rule::exists('statuses', 'id')],
        ];
    }
}
