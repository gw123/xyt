<?php
namespace Common\exception;
use  yii\base;

class  FileException extends \Exception
{
    public function getName()
    {
        return 'FileException';
    }
}
