<?php


namespace M2MAPP;

class Validator
{
    public function __construct() {

    }

    public function __destruct() {

    }

    public function sanitiseString($string_to_sanitise)
    {
        $sanitised_string = '';

        if (!empty($string_to_sanitise)) {
            $sanitised_string = filter_var($string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    public function sanitiseEmail($email_to_sanitise)
    {
        $cleaned_string = '';

        if (!empty($email_to_sanitise)) {
            $sanitised_email = filter_var($email_to_sanitise, FILTER_SANITIZE_EMAIL);
            $cleaned_string = filter_var($sanitised_email, FILTER_VALIDATE_EMAIL);
        }
        return $cleaned_string;
    }


}