<?php

namespace App\Http\Requests;

use App\Rules\RoomNotUsing;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
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
        $date = $this->get('arrivalDate', null) ?? $this->booking->arrivalDate;
        return [
            'room_id' => ['nullable', 'exists:rooms,id', new RoomNotUsing($date)],
            'arrivalDate' => 'nullable|date'
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
