<?php

namespace App\Http\Requests;

use App\Models\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'required',
            ],
            'start_at' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_at' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
