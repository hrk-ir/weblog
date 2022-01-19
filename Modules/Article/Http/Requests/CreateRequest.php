<?php

namespace Modules\Article\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Modules\Category\Entities\Category;
use Symfony\Component\HttpFoundation\Response;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|unique:articles,title|min:5|max:255',
            'image' => 'required|file|mimes:jpg,webp,png|max:10240',
            'body' => 'required',
            'category_id' => 'integer|exists:categories,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   =>  false,
            'status'    =>  Response::HTTP_UNAUTHORIZED,
            'message'   =>  'Validation errors',
            'data'      =>  $validator->errors()
        ]));
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
