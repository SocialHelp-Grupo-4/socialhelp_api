<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required|string|max:100|unique:institutions,name,' . $this->route('institution')->id,
            'nif' => 'required|string|max:14|unique:institutions,nif,' . $this->route('institution')->id,
            'email' => 'required|email|max:100|unique:institutions,email,' . $this->route('institution')->id,

        ];
    }
}
