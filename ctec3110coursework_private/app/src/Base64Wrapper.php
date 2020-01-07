<?php

namespace M2MAPP;

class Base64Wrapper
{
    public function __construct(){}

    public function __destruct(){}

    public function encode_base64($string_to_encode)
    {
        $encoded_string = false;
        if (!empty($string_to_encode))
        {
            $encoded_string = base64_encode($string_to_encode);
        }
        return $encoded_string;
    }

    public function decode_base64($string_to_decode)
    {
        $decoded_string = false;
        if (!empty($string_to_decode))
        {
            $decoded_string = base64_decode($string_to_decode);
        }
        return $decoded_string;
    }
}