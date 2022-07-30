<?php

namespace App\Http\Requests\Order;

use App\Models\Block;
use App\Rules\DiffNumber;
use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'size' => 'required|integer',
            'temperature' => 'required|integer',
            'block' => 'required|integer|exists:' . Block::$tableName . ',id',
            'date_start' => ['required', 'integer', new DiffNumber('date_end', 24)],
            'date_end' => 'required|integer',
        ];
    }
}
