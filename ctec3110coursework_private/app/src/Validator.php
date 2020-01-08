<?php


namespace M2MAPP;

class Validator
{
    public function __construct() {

    }

    public function __destruct() {

    }

    public function validateDownloadedMessage($message_content)
    {
        $validated_message_content = '';

        $validated_message_content = filter_var($message_content, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        return $validated_message_content;
    }

    public function sanitiseString(string $string_to_sanitise): string
    {
        $sanitised_string = false;

        if (!empty($string_to_sanitise)) {
            $sanitised_string = filter_var($string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    public function sanitiseEmail(string $email_to_sanitise): string
    {
        $cleaned_string = false;

        if (!empty($email_to_sanitise)) {
            $sanitised_email = filter_var($email_to_sanitise, FILTER_SANITIZE_EMAIL);
            $cleaned_string = filter_var($sanitised_email, FILTER_VALIDATE_EMAIL);
        }
        return $cleaned_string;
    }


}