<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property mixed $tariffId
 * @property mixed $date
 * @property mixed $phone
 * @property mixed $name
 * @property mixed $deliveryAddress
 */
class CreateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'date' => 'required',
            'phone' => 'required|min:11|max:11',
            'deliveryAddress' => 'required|max:255',
            'tariffId' => 'required|int'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => -1,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ])
        );
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле имя обязательно для заполнения',
            'date.required' => 'Поле дата обязательно для заполнения',
            'deliveryAddress.required' => 'Поле адрес доставки обязательно для заполнения',
            'tariffId.required' => 'Тариф обязателен для заполнения',
            'phone.*' => 'Телефон должен содержать 11 символов'
        ];
    }
}
