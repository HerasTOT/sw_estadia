<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalendarRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date_start'        => "required|string|max:50",
            'date_end'        => "required|string|max:50",
            'id_announcements'        => "required|string|max:50",
            'id_events'        => "required|string|max:50",
            'observations'        => "required|string|max:50",
        ];
    }
}
