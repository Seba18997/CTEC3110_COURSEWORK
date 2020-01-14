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
        $this->sid      = null;
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

    public function setSessionId($sid)
    {
        $this->sid = $sid;
    }

    public function setSessionWrapperFile($session_wrapper)
    {
        $this->session_wrapper_file = $session_wrapper;
    }

    public function storeData()
    {
        $store_result = false;
        $store_result_username
            = $this->session_wrapper_file->setSessionVar('username', $this->username);

        $store_result_password
            = $this->session_wrapper_file->setSessionVar('password', $this->password);

        $store_result_sid
            = $this->session_wrapper_file->setSessionVar('sid', $this->sid);

        if ($store_result_username !== false && $store_result_password !== false && $store_result_sid !== false)	{
            $store_result = true;
        }
        return $store_result;
    }

}