<?php

namespace tests;

use io\FileOutputStream;
use PHPUnit\Framework\TestCase;

/**
 * 文件输出
 * Class FileOutputStreamTest
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package tests
 */
class FileOutputStreamTest extends TestCase
{
    /**
     * @var FileOutputStream
     */
    private $out;

    protected function setUp(): void
    {
        $this->out = new FileOutputStream(fopen(__DIR__ . '/data.bin', 'w'));
    }


    public function testWrite()
    {
        $data = pack('NN', 1, 0xff);
        $this->assertEquals(8, $this->out->write($data));
        $this->assertTrue($this->out->flush());
        $this->assertTrue($this->out->close());
    }
}
