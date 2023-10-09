<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementsRequest extends FormRequest
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
            'name'        => "required|string|max:50",
            'description'        => "required|string|max:255",
            'num_announcement'        => "required|integer|max:50",
            'y_announcement'        => "required|integer",
            'status'        => "required|integer|max:50",
            'institutions_id' => "required|integer|max:45",
            'myFiles' => "exclude",
            'dates' => "exclude"
        ];
    }
}
