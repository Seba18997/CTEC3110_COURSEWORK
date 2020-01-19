<?php


namespace M2MAPP;

class Validator
{
    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    /**
     * @param array $array_to_sanitise
     * @return mixed
     */
    public function sanitiseArray($array_to_sanitise=[])
    {
        if (!empty($array_to_sanitise)) {
            $sanitised_array = filter_var_array($array_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_array;
    }

    /**
     * @param $string_to_sanitise
     * @return mixed|string
     */
    public function sanitiseString($string_to_sanitise)
    {
        $sanitised_string = '';

        if (!empty($string_to_sanitise)) {
            $sanitised_string = filter_var($string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    /**
     * @param $email_to_sanitise
     * @return mixed|string
     */
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