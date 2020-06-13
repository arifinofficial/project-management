<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'job.name' => 'required|string|max:255',
            'job.category.*' => 'required|numeric|min:0',
            'job.start' => 'required',
            'job.end' => 'required',
            'job.description' => 'nullable|string',
            'departements.*.name' => 'required|string|max:255',
            'departements.*.user_id' => 'required|numeric|min:0',
            'departements.*.tasks.*.name' => 'required|string|max:255',
            'departements.*.tasks.*.status' => 'required|string|max:255',
            'departements.*.tasks.*.description' => 'nullable|string',
        ];
    }
}
