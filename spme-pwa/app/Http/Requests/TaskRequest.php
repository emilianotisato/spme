<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        if ($this->method() === 'POST') {
            return [
                'assigned_user' => 'nullable|exists:users,id',
                'project_id' => 'required|exists:projects,id',
                'priority_id' => 'required|exists:priorities,id',
                'status_id' => 'required|exists:statuses,id',
                'client_visibility' => 'boolean',
                'subject' => 'required|string',
                'description' => 'nullable|string',
                'closed' => 'date',
            ];

        }

        if ($this->method() === 'PATCH') {
            return [
                'assigned_user' => 'sometimes|nullable|exists:users,id',
                'project_id' => 'sometimes|required|exists:projects,id',
                'priority_id' => 'sometimes|required|exists:priorities,id',
                'status_id' => 'sometimes|required|exists:statuses,id',
                'client_visibility' => 'sometimes|boolean',
                'subject' => 'sometimes|required|string',
                'description' => 'sometimes|nullable|string',
                'closed' => 'sometimes|date',
            ];

        }
    }
}
