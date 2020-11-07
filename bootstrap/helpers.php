<?php

use Illuminate\Validation\ValidationException;

if (!function_exists('validation_fails')) {
    function validation_fails(string $key, string $message)
    {
        throw ValidationException::withMessages([$key => $message]);
    }
}
