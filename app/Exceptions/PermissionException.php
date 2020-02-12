<?php

namespace App\Exceptions;

use Exception;

class PermissionException extends Exception
{
    const NOT_RULE = 403;
    public static $errMsg = [
        PermissionException::NOT_RULE => '您没有权限！'
    ];
    public $errorMsg = "";
    public $errorNo = "";
    public function __construct($errorNo, $msg="")
    {
        if($errorNo && $msg) {
            $this->errorNo   = $errorNo;
            $this->errorMsg    = $msg;
            parent::__construct($msg, $errorNo);
            return true;
        }
        $this->errorNo   = $errorNo;
        if(!empty($msg)) {
            $this->errorMsg  = $msg;
        } else {
            $this->errorMsg  = PermissionException::$errMsg[$errorNo];
        }
        parent::__construct($msg);
    }

    /**
     * 错误信息
     * @return mixed|string
     */
    public function getErrorMsg(){
        return $this->errorMsg;
    }

    /**
     * 错误码
     * @return string
     */
    public function getErrorNo() {
        return $this->errorNo;
    }
}
