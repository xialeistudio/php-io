<?php
declare(strict_types=1);

namespace io;

/**
 * 输出流
 * Class OutputStream
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
abstract class OutputStream implements Closable
{
    /**
     * 写入指定字节
     * @param string $string
     * @return int 写入的字节数
     */
    abstract public function write(string $string): int;

    /**
     * 刷新输出缓冲
     * @return bool
     */
    abstract public function flush();
}