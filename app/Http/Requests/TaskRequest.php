<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => ['required', Rule::in([Task::STATUS_PENDING, Task::STATUS_IN_PROGRESS, Task::STATUS_COMPLETED])],
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O título da tarefa é obrigatório.',
            'title.max' => 'O título da tarefa não pode ter mais de 255 caracteres.',
            'description.max' => 'A descrição não pode ter mais de 1000 caracteres.',
            'status.required' => 'O status da tarefa é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
            'assigned_to.exists' => 'O usuário selecionado não existe.',
        ];
    }
}
