<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $isUpdate = Request::isMethod('patch');

        return [
            "title" => [Rule::when($isUpdate, "sometimes"), "required", "string", "max:255"],
            "description" => [Rule::when($isUpdate, "sometimes"), "required", "string", "max:2000"],
            "image" => [Rule::when($isUpdate, ["sometimes", "nullable"], ["required"]), "image", "max:2000"],
            "price" => [Rule::when($isUpdate, "sometimes"), "required", "numeric", "min:0.1"],
            "in_stock" => [Rule::when($isUpdate, "sometimes"), "required", Rule::in(["yes", "no"])],
            "category" => [Rule::when($isUpdate, "sometimes"), "required", Rule::exists("categories", "id")]
        ];
    }
}
