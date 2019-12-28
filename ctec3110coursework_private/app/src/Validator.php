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

        $validated_message_content = filter_var($message_content, FILTER_SANITIZE_STRING);

        return $validated_message_content;
    }


}