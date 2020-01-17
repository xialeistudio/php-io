<?php

namespace tests;

use io\FileInputStream;
use PHPUnit\Framework\TestCase;

/**
 * 文件输入流
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package tests
 */
class FileInputStreamTest extends TestCase
{
    /**
     * @var FileInputStream
     */
    private $in;

    /**
     * @deprecated FileOutputStream::closex
     */
    protected function setUp(): void
    {
        $this->in = new FileInputStream(fopen(__DIR__ . '/data.bin', 'r'));
    }

    public function testRead()
    {
        $binary4 = $this->in->read(4);
        $data = unpack('N', $binary4)[1];
        $this->assertEquals(1, $data);

        $this->in->skip(2);

        $binary2 = $this->in->read(2);
        $data = unpack('n', $binary2)[1];
        $this->assertEquals(0xff, $data);
    }
}
