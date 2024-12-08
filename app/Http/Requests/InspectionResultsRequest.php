<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InspectionResultsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true to allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // General Information
            'dateTest' => 'nullable|date',
            'id' => '',
            'typeTest' => 'nullable|string|max:255',
            'plantSupplier' => 'nullable|string|max:255',
            'lotSize' => 'nullable|numeric|min:0',

            // Sample Size
            'contamination' => 'nullable|numeric|min:0',
            'humidity' => 'nullable|numeric|min:0|max:100',

            // Inorganic Contamination
            'ceramics_pc' => 'nullable|integer|min:0',
            'stones_pc' => 'nullable|integer|min:0',
            'porcelain_pc' => 'nullable|integer|min:0',
            'ceramic_gr' => 'nullable|numeric|min:0',
            'stones_gr' => 'nullable|numeric|min:0',
            'porcelain_gr' => 'nullable|numeric|min:0',
            'opalGlass' => 'nullable|numeric|min:0',

            // Metal Contamination
            'magnetic' => 'nullable|numeric|min:0',
            'nonMagnetic' => 'nullable|numeric|min:0',

            // Moisture and Organic Contamination
            'organicMatter' => 'nullable|numeric|min:0',
            'plasticSeperate' => 'nullable|numeric|min:0',

            // General Quality Requirements
            'pyroGlass_gr' => 'nullable|numeric|min:0',
            'pyroGlass_pc' => 'nullable|integer|min:0',

            // Granulometry / Sizing
            'largerThan70mm' => 'nullable|numeric|min:0',
            'largerThan10mm' => 'nullable|numeric|min:0',
            'between5mmAnd10mm' => 'nullable|numeric|min:0',
            'smallerThan5mm' => 'nullable|numeric|min:0',

            // Color Specification
            'flint' => 'nullable|numeric|min:0',
            'green' => 'nullable|numeric|min:0',
            'amber' => 'nullable|numeric|min:0',
            'deadLeaf' => 'nullable|numeric|min:0',
            'blue' => 'nullable|numeric|min:0',
        ];
    }
}
