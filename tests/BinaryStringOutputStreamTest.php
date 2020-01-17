<?php

namespace tests;

use io\BinaryStringOutputStream;
use PHPUnit\Framework\TestCase;

/**
 * 二进制输入流
 * Class BinaryStringOutputStreamTest
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package tests
 */
class BinaryStringOutputStreamTest extends TestCase
{

    public function testWrite()
    {
        $out = new BinaryStringOutputStream();
        $packed = pack('N', 0x12345678);
        $out->write($packed);

        $binary = $out->toBinaryString();
        $this->assertEquals(0x12345678, unpack('N', $binary)[1]);
    }

    public function testToBinaryString()
    {

        $out = new BinaryStringOutputStream();
        $packed = pack('N', 0x12345678);
        $out->write($packed);

        $binary = $out->toBinaryString();
        $this->assertEquals($packed, $binary);
    }
}
