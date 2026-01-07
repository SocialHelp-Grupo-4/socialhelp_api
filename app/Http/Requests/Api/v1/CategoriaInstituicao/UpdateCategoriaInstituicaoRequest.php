<?php

namespace App\Http\Requests\Api\V1\CategoriaInstituicao;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaInstituicaoRequest extends FormRequest
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
            'nome' => 'required|string|max:100|unique:categoria_instituicaos,nome,' . $this->categoriaInstituicao->id,

        ];
    }
}
