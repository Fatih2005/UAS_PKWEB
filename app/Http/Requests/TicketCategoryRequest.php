<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120', 'unique:ticket_categories,slug' . ($this->route('ticket_category')?->id ? ',' . $this->route('ticket_category')->id : '')],
            'description' => ['nullable', 'string', 'max:1000'],
            'sla_hours' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
