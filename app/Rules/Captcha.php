<?php

namespace App\Rules;

use ReCaptcha\ReCaptcha;
use Illuminate\Contracts\Validation\Rule;

class Captcha implements Rule
{

    public function __construct()
    {

    }

    public function passes($attribute, $value)
    {
        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));
        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);
        return $response->isSuccess();
    }


    public function message()
    {
        //return 'The validation error message.';
        return 'Please complete the reCaptcha to submit the form';
    }
}
