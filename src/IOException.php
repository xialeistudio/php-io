<?php
declare(strict_types=1);

namespace io;

use Exception;
use Throwable;

/**
 * IO异常
 * Class IOException
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
class IOException extends Exception
{
    public function __construct($message = "IO异常", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}