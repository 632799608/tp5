<?php
namespace app\common\tools;

class Result {

    public $code;
    public $message;

    public function __construct()
    {
        $this->code = 200;
        $this->message = '成功';
    }
    public function toJson()
    {
        return $this;
    }

}
