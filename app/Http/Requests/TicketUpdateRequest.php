<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'category_id' => ['nullable', 'exists:ticket_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'description' => ['nullable', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf,zip,doc,docx'],
        ];

        if (auth()->user()->is_admin) {
            $rules['status'] = ['required', Rule::in(['open', 'in_progress', 'resolved', 'closed'])];
            $rules['assigned_to'] = ['nullable', 'exists:users,id'];
        }

        return $rules;
    }
}
