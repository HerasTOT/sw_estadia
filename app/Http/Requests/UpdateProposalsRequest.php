<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProposalsRequest extends FormRequest
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
            'title' => "required|string|max:255",
            'line_research' => "required|string|max:255",
            'abstract' => "required|string|max:255",
            'problem_statement' => "required|string|max:255",
            'justification' => "required|string|max:255",
            'background' => "required|string|max:255",
            'technical_manager_experience' => "required|string|max:255",
            'capcities' => "required|string|max:255",
            'general_objective' => "required|string|max:255",
            'specific_objective' => "required|string|max:255",
            'expected_results' => "required|string|max:255",
            'expected_results_review' => "required|string|max:255",
            'differentiators' => "required|string|max:255",
            'benefits' => "required|string|max:255",
            'products_generated' => "required|string|max:255",
            'ownership_proposal' => "required|string|max:255",
            'announcement_id' => "required|integer|max:255",
            'area_knowledge_id' => "required|integer|max:255",
            'user_id' => "required|integer|max:255",
            'state_id' => "required|integer|max:255",
            'myFiles' => "exclude",
        ];
    }
}
