<?php

namespace tests;

use io\BinaryStringInputStream;
use PHPUnit\Framework\TestCase;

/**
 * 二进制输入流测试
 * Class BinaryStringInputStreamTest
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package tests
 */
class BinaryStringInputStreamTest extends TestCase
{

    public function testRead()
    {
        $unsignedInt = 0x12345678;
        $packed = pack('N', $unsignedInt);
        $in = new BinaryStringInputStream($packed);
        $binary = $in->read(4);
        $this->assertEquals($unsignedInt, unpack('N', $binary)[1]);
    }

    public function testSkip()
    {
        $data = '12345678';
        $packed = pack('A8', $data);
        $in = new BinaryStringInputStream($packed);
        $string = unpack('A4', $in->read(4))[1];
        $this->assertEquals('1234', $string);

        $in->skip(2);

        $string = unpack('A2', $in->read(2))[1];
        $this->assertEquals('78', $string);
    }
}
