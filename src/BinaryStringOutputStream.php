<?php
declare(strict_types=1);

namespace io;

/**
 * 二进制输出流
 * Class BinaryStringOutputStream
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
class BinaryStringOutputStream extends OutputStream
{
    /**
     * @var string 二进制字符串
     */
    protected $buf;

    /**
     * 关闭资源
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * 写入指定字节
     * @param string $string
     * @return int
     */
    public function write(string $string): int
    {
        $this->buf .= $string;
        return strlen($string);
    }

    /**
     * 刷新输出缓冲
     * @return bool
     */
    public function flush()
    {
        return true;
    }

    /**
     * 获取二进制字符串
     * @return string
     */
    public function toBinaryString()
    {
        return $this->buf;
    }
}