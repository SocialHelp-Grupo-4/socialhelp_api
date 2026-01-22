<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInstitutionRequest extends FormRequest
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
        $institution = $this->route('institution');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('institutions', 'name')->ignore($institution),
            ],
            'nif' => [
                'required',
                'string',
                'max:14',
                Rule::unique('institutions', 'nif')->ignore($institution),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('institutions', 'email')->ignore($institution),
            ],
        ];
    }
}
