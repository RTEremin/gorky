<?php

namespace App\Rules;

use App\Models\Booking;
use Illuminate\Contracts\Validation\Rule;

class RoomNotUsing implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected $arrivalDate)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return isset($this->arrivalDate) && !Booking::where([
            ['room_id', '=', $value],
            ['arrivalDate', '=', $this->arrivalDate]
        ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Данный номер занят на данную дату!';
    }
}
