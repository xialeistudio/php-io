<?php


namespace io;

/**
 * 文件输入流
 * Class FileInputStream
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
class FileInputStream extends InputStream
{
    /**
     * @var resource 文件句柄
     */
    protected $fp;

    /**
     * FileInputStream constructor.
     * @param resource $fp
     */
    public function __construct($fp)
    {
        $this->fp = $fp;
    }

    /**
     * 关闭资源
     * @return bool
     */
    public function close()
    {
        return fclose($this->fp);
    }

    /**
     * 读取指定长度字节
     * @param int $length
     * @return string
     * @throws IOException
     */
    public function read(int $length): string
    {
        $result = fread($this->fp, $length);
        if ($result === false) {
            throw new IOException();
        }
        return $result;
    }

    /**
     * 跳过指定长度字节
     * @param int $length
     * @return int
     * @throws IOException
     */
    public function skip(int $length): int
    {
        if (fseek($this->fp, $length, SEEK_CUR) === -1) {
            throw new IOException();
        }
        return $length;
    }
}