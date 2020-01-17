<?php
declare(strict_types=1);

namespace io;

/**
 *
 * Class DataOutputStream
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
class DataOutputStream extends OutputStream
{
    use ConvertTrait;
    /**
     * @var OutputStream
     */
    protected $out;

    /**
     * DataOutputStream constructor.
     * @param OutputStream $out
     */
    public function __construct(OutputStream $out)
    {
        $this->out = $out;
    }

    /**
     * 关闭资源
     * @return bool
     */
    public function close()
    {
        return $this->out->close();
    }

    /**
     * 写入指定字节
     * @param string $string
     * @return int 写入的字节数
     */
    public function write(string $string): int
    {
        return $this->out->write($string);
    }

    /**
     * 刷新输出缓冲
     * @return bool
     */
    public function flush()
    {
        return $this->out->flush();
    }

    /**
     * 输出有符号Byte
     * @param int $char
     * @return int
     */
    public function writeChar(int $char)
    {
        $data = pack('c', $char);
        $this->write($data);
        return 1;
    }

    /**
     * 输出无符号Byte
     * @param int $char
     * @return int
     */
    public function writeUnSignedChar(int $char)
    {
        $data = pack('C', $char);
        return $this->write($data);
    }

    /**
     * 输出有符号大端短整形
     * @param int $short
     * @return int
     */
    public function writeShortBE(int $short)
    {
        $unsigned = $this->convertSignedShortToUnSignedShort($short);
        return $this->writeUnSignedShortBE($unsigned);
    }

    /**
     * 输出无符号大端序短整形
     * @param int $short
     * @return int
     */
    public function writeUnSignedShortBE(int $short)
    {
        $data = pack('n', $short);
        return $this->write($data);
    }

    /**
     * 输出无符号小端序短整形
     * @param int $short
     * @return int
     */
    public function writeUnSignedShortLE(int $short)
    {
        $data = pack('v', $short);
        return $this->write($data);
    }

    /**
     * 输出有符号小端短整形
     * @param int $short
     * @return int
     */
    public function writeShortLE(int $short)
    {
        $unsigned = $this->convertSignedShortToUnSignedShort($short);
        return $this->writeUnSignedShortLE($unsigned);
    }

    /**
     * 输出有符号大端整型
     * @param int $int
     * @return int
     */
    public function writeIntBE(int $int)
    {
        $unsigned = $this->convertSignedIntToUnSignedInt($int);
        return $this->writeUnSignedIntBE($unsigned);
    }

    /**
     * 输出无符号大端序整型
     * @param int $int
     * @return int
     */
    public function writeUnSignedIntBE(int $int)
    {
        $data = pack('N', $int);
        return $this->write($data);
    }

    /**
     * 输出无符号小端序整型
     * @param int $int
     * @return int
     */
    public function writeUnSignedIntLE(int $int)
    {
        $data = pack('V', $int);
        return $this->write($data);
    }

    /**
     * 输出有符号小端整型
     * @param int $int
     * @return int
     */
    public function writeIntLE(int $int)
    {
        $unsigned = $this->convertSignedIntToUnSignedInt($int);
        return $this->writeUnSignedIntLE($unsigned);
    }

    /**
     * 输出UTF8字符串
     * @param string $string
     * @return int
     */
    public function writeString(string $string)
    {
        $length = strlen($string);
        $data = pack('A' . $length, $string);
        return $this->write($data);
    }
}