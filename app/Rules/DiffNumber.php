<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class DiffNumber implements Rule, DataAwareRule
{
    protected $field;
    protected $size;
    protected $data = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($field, $size)
    {
        $this->field = $field;
        $this->size = $size;
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
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
        return abs($this->data[$this->field] - $value) < $this->size;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The difference in value :attribute and ' .$this->field. ' must be less than';
    }
}
