<?php
declare(strict_types=1);

namespace io;

/**
 * 二进制字符串输入流
 * Class BinaryStringInputStream
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
class BinaryStringInputStream extends InputStream
{
    /**
     * @var string 二进制字符串
     */
    protected $buf;

    /**
     * @var int 当前字节偏移量
     */
    protected $offset = 0;

    /**
     * BinaryStringInputStream constructor.
     * @param string $buf
     */
    public function __construct(string $buf)
    {
        $this->buf = $buf;
    }

    /**
     * 关闭资源
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * 读取指定长度字节
     * @param int $length
     * @return string
     * @throws InvalidParamException
     */
    public function read(int $length): string
    {
        if ($length < 0) {
            throw new InvalidParamException();
        } elseif ($length == 0) {
            return '';
        }

        $str = substr($this->buf, $this->offset, $length);
        $this->offset += $length;
        return $str;
    }

    /**
     * 跳过指定长度字节
     * @param int $length
     * @return int
     * @throws InvalidParamException
     */
    public function skip(int $length): int
    {
        if ($length < 0) {
            throw new InvalidParamException();
        } elseif ($length == 0) {
            return 0;
        }

        $this->offset += $length;
        return $length;
    }
}