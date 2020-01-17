<?php
declare(strict_types=1);

namespace io;

/**
 * 文件输出流
 * Class FileOutputStream
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package io
 */
class FileOutputStream extends OutputStream
{
    /**
     * @var resource 文件句柄
     */
    protected $fp;

    /**
     * FileOutputStream constructor.
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
        $this->flush();
        return fclose($this->fp);
    }

    /**
     * 写入指定字节
     * @param string $string
     * @return int
     */
    public function write(string $string): int
    {
        return fwrite($this->fp, $string);
    }

    /**
     * 刷新输出缓冲
     * @return bool
     */
    public function flush()
    {
        return fflush($this->fp);
    }
}