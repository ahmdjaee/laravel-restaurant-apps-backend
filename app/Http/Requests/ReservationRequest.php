<?php

namespace App\Http\Requests;

use App\Utils\Enum\StatusReservation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
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
            'table_id' => ['required', 'exists:tables,id'],
            'date' => ['required'],
            'time' => ['required'],
            'persons' => ['required', 'numeric'],
            'notes' => ['nullable'],
            'status' => ['nullable', Rule::enum(StatusReservation::class)->only([
                StatusReservation::canceled,
                StatusReservation::confirmed,
                StatusReservation::pending,
                StatusReservation::completed    
            ])]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag()
        ], 400));
    }
}
