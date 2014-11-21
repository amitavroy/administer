<?php
/**
 * Created by PhpStorm.
 * User: amitav
 * Date: 21/11/14
 * Time: 5:26 PM
 */

class CustomValidation extends Illuminate\Validation\Validator {

    /*
     * Validation for confirming passwords.
     */
    public function validateMatchpass($attribute, $value, $parameters)
    {
        $cPassword = $parameters[0];
        if ($cPassword == $value)
            return $value == $cPassword;
    }
} 