<?php
declare(strict_types=1);

namespace io;

/**
 * 复杂
 * Class DataInputStream
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
class DataInputStream extends InputStream
{
    use ConvertTrait;
    /**
     * @var InputStream
     */
    protected $in;

    /**
     * DataInputStream constructor.
     * @param InputStream $in
     */
    public function __construct(InputStream $in)
    {
        $this->in = $in;
    }

    /**
     * 关闭资源
     * @return bool
     */
    public function close()
    {
        return $this->in->close();
    }

    /**
     * 读取指定长度字节
     * @param int $length
     * @return string
     */
    public function read(int $length): string
    {
        return $this->in->read($length);
    }

    /**
     * 跳过指定长度字节
     * @param int $length
     * @return int 跳过的字节数
     */
    public function skip(int $length): int
    {
        return $this->in->skip($length);
    }

    /**
     * 读取有符号单字节数
     * @return int
     */
    public function readChar(): int
    {
        $data = $this->read(1);
        $data = unpack('c', $data);
        return $data[1];
    }

    /**
     * 读取无符号单字节数
     * @return int
     */
    public function readUnSignedChar(): int
    {
        $data = $this->read(1);
        $data = unpack('C', $data);
        return $data[1];
    }

    /**
     * 读取有符号大端短整型
     * @return int
     */
    public function readShortBE(): int
    {
        $unsigned = $this->readUnSignedShortBE();
        return $this->convertUnSignedShortToSignedShort($unsigned);
    }

    /**
     * 读取无符号大端序短整型
     * @return int
     */
    public function readUnSignedShortBE(): int
    {
        $data = $this->read(2);
        $data = unpack('n', $data);
        return $data[1];
    }

    /**
     * 读取无符号小端序短整型
     * @return int
     */
    public function readUnSignedShortLE(): int
    {
        $data = $this->read(2);
        $data = unpack('v', $data);
        return $data[1];
    }

    /**
     * 读取有符号小端短整型
     * @return int
     */
    public function readShortLE(): int
    {
        $unsigned = $this->readUnSignedShortLE();
        return $this->convertUnSignedShortToSignedShort($unsigned);
    }

    /**
     * 读取有符号大端整型
     * @return int
     */
    public function readIntBE(): int
    {
        $unsigned = $this->readUnSignedIntBE();
        return $this->convertUnSignedIntToSignedInt($unsigned);
    }

    /**
     * 读取无符号大端序整型
     * @return int
     */
    public function readUnSignedIntBE(): int
    {
        $data = $this->read(4);
        $data = unpack('N', $data);
        return $data[1];
    }

    /**
     * 读取有符号小端整型
     * @return int
     */
    public function readIntLE(): int
    {
        $unsigned = $this->readUnSignedIntLE();
        return $this->convertUnSignedIntToSignedInt($unsigned);
    }

    /**
     * 读取无符号小端序整型
     * @return int
     */
    public function readUnSignedIntLE(): int
    {
        $data = $this->read(4);
        $data = unpack('V', $data);
        return $data[1];
    }

    /**
     * 读取字符串
     * @param int $length 字节长度
     * @return string
     */
    public function readString(int $length): string
    {
        $data = $this->read($length);
        $data = unpack('A' . $length, $data);
        return $data[1];
    }
}