<?php

namespace App\Http\Requests;

use App\Utils\Enum\TypeEvent;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'active' => ['nullable', 'boolean'],
            'event_start' => ['required', 'date'],
            'event_end' => ['required', 'date'],
            'type' => [
                'required', 'string',
                Rule::enum(TypeEvent::class)
                    ->only([
                        TypeEvent::promo,
                        TypeEvent::concert,
                        TypeEvent::flashSale,
                        TypeEvent::workshop,
                        TypeEvent::festival
                    ])
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag()
        ], 400));
    }


    protected function failedAuthorization()
    {
        throw new HttpResponseException(response([
            'errors' => [
                'message' => 'This action is not allowed.'
            ]
        ], 403));
    }
}
