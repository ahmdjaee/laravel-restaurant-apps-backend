<?php

namespace App\Http\Requests;

use App\Utils\Enum\StatusTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
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
            'order_id' => ['required'],
            // 'code' => ['required'], provide by payment gateway
            'provider' => ['nullable'],
            'status' => ['required', Rule::enum(StatusTransaction::class)->only([
                StatusTransaction::new,
                StatusTransaction::cancelled,
                StatusTransaction::failed,
                StatusTransaction::pending,
                StatusTransaction::rejected,
                StatusTransaction::success
            ])]
        ];
    }
}
