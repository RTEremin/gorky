<?php

namespace App\Http\Requests;

use App\Rules\RoomNotUsing;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
        return [
            'arrivalDate' => 'required|date',
            'room_id' => [
                'required',
                'exists:rooms,id',
                new RoomNotUsing($this->get('arrivalDate', null))
            ]
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения!',
            'exists' => 'Поле :attribute не существует в таблице базы данных!',
            'date' => 'Поле :attribute содержит данные не виде даты!'
        ];
    }
}
