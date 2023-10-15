<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'status' => ['required', new Enum(TaskStatusEnum::class)],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
