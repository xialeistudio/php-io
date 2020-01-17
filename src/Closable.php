<?php
declare(strict_types=1);

namespace io;

/**
 * Interface Closable
 * @package io
 */
interface Closable
{
    /**
     * 关闭资源
     * @return bool
     */
    public function close();
}