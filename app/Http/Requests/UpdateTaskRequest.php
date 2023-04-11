<?php

namespace App\Http\Requests;

use App\Models\Task;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('task_edit');
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
            'deadline' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'status' => [
                'required',
            ],
            'department_id' => [
                'required',
                'integer',
            ],
            'project_id' => [
                'required',
                'integer',
            ],
            'department_employees_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
