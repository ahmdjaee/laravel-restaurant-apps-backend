<?php

namespace App\Http\Requests;

use App\Utils\Enum\StatusOrder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['required'], // array
            'reservation_id' => ['required', 'numeric'],
            'status' => ['nullable', Rule::enum(StatusOrder::class)
                ->only([
                    StatusOrder::new,
                    StatusOrder::checkout,
                    StatusOrder::paid,
                    StatusOrder::failed,
                    StatusOrder::completed
                ])],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag()
        ], 400));
    }
}
