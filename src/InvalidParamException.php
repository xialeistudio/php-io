<?php
declare(strict_types=1);

namespace io;

use Exception;
use Throwable;

/**
 * Class InvalidParamException
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
class InvalidParamException extends Exception
{
    public function __construct($message = "参数异常", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}