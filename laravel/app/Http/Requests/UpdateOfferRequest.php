<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
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
            'description' => 'required|string',  
            'contract_type' => 'required|string', 
            'location' => 'required|string',
            'salary' => 'required|numeric',       
        ];
    }
    public function messages()
    {
        return [
          
            'title.required' => 'Le titre est requis.',
            'description.required' => 'La description est requise.',
            'contract_type.required' => 'Le type de contrat est requis.',
            'location.required' => 'Le lieu est requis.',
            'salary.required' => 'Le salaire est requis.',
        ];
    }
}
