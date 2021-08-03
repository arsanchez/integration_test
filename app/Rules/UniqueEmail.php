<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Util\MailerLiteConnector;


class UniqueEmail implements Rule
{
    private $id;
    private $connector;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id, MailerLiteConnector $connector)
    {
        $this->id = $id;
        $this->connector = $connector;
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
        $temp_s = $this->connector->findSubscriber($value);
        if ( (isset($temp_s->id) && $this->id == 0) 
             || ($this->id > 0 && $temp_s->id != $this->id)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This email is already in use.';
    }
}
