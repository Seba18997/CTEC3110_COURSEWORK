<?php


namespace M2MAPP;


class SessionModel
{
    private $username;
    private $password;
    private $storage_result;
    private $session_wrapper_file;

    public function __construct()
    {
        $this->username = null;
        $this->password = null;
        $this->storage_result = null;
        $this->session_wrapper_file = null;
    }

    public function __destruct() { }

    public function getStorageResult()
    {
        return $this->storage_result;
    }

    public function setSessionUsername($username)
    {
        $this->username = $username;
    }

    public function setSessionPassword($password)
    {
        $this->password = $password;
    }

    public function setSessionWrapperFile($session_wrapper)
    {
        $this->session_wrapper_file = $session_wrapper;
    }

    public function storeData()
    {
        $store_result = false;
        $store_result_username
            = $this->session_wrapper_file->setSessionVar('user_name', $this->username);

        $store_result_password
            = $this->session_wrapper_file->setSessionVar('password', $this->password);

        if ($store_result_username !== false && $store_result_password !== false)	{
            $store_result = true;
        }
        return $store_result;
    }

}