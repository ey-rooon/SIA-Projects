<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class QuantityRule implements Rule
{

    protected $quantityLeft;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($quantityLeft)
    {
        //
        $this->quantityLeft = $quantityLeft;
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
        //
        return $this->quantityLeft >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not enough quantity.';
    }
}
