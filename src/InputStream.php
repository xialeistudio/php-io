<?php
declare(strict_types=1);

namespace io;

/**
 * 输入流
 * Class InputStream
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
abstract class InputStream implements Closable
{
    /**
     * 读取指定长度字节
     * @param int $length
     * @return string
     */
    abstract public function read(int $length): string;

    /**
     * 跳过指定长度字节
     * @param int $length
     * @return int 跳过的字节数
     */
    abstract public function skip(int $length): int;
}