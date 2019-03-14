<?php
namespace manage\middlewares;
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/4/13
 * Time: 下午4:02
 */

class MidException extends \Exception
{
    protected $ErrorInfo;

    public function __construct($message=null,$code=0)
    {
        $this->ErrorInfo = __CLASS__;
        parent::__construct($message,$code);
    }

    public function GetErrorInfo()
    {
        return $this->ErrorInfo;
    }
}