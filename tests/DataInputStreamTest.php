<?php

namespace tests;

use io\BinaryStringInputStream;
use io\DataInputStream;
use PHPUnit\Framework\TestCase;

/**
 * Class DataInputStreamTest
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package tests
 */
class DataInputStreamTest extends TestCase
{
    public function testReadString()
    {
        $data = pack('A6', '哈哈');
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $string = $in->readString(6);
        $this->assertEquals('哈哈', $string);
    }

    public function testClose()
    {
        $data = pack('A6', '哈哈');
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertTrue($in->close());
    }

    public function testRead()
    {
        $data = pack('c', 100);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals($data, $in->read(1));
    }

    public function testReadChar()
    {
        $data = pack('c', 100);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals(100, $in->readChar());
    }

    public function testReadUnSignedShortLE()
    {
        $data = pack('v', 100);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals(100, $in->readUnSignedShortLE());
    }

    public function testReadUnSignedShortBE()
    {
        $data = pack('n', 100);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals(100, $in->readUnSignedShortBE());
    }

    public function testReadUnSignedChar()
    {
        $data = pack('C', 255);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals(255, $in->readUnSignedChar());
    }

    public function testSkip()
    {
        $data = pack('vv', 100, 102);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals(2, $in->skip(2));
        $this->assertEquals(102, $in->readUnSignedShortLE());
    }

    public function testReadUnSignedIntBE()
    {
        $data = pack('N', 0xffffffff);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals(0xffffffff, $in->readUnSignedIntBE());
    }

    public function testReadUnSignedIntLE()
    {
        $data = pack('V', 0x12345678);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals(0x12345678, $in->readUnSignedIntLE());
    }

    public function testReadShortBE()
    {
        $signed = -100;
        $data = pack('n', $signed + 0x10000);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals($signed, $in->readShortBE());
    }

    public function testReadShortLE()
    {
        $signed = -100;
        $data = pack('v', $signed + 0x10000);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals($signed, $in->readShortLE());
    }

    public function testReadIntBE()
    {
        $signed = -100;
        $data = pack('N', $signed + 0x100000000);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals($signed, $in->readIntBE());
    }

    public function testReadIntLE()
    {
        $signed = -100;
        $data = pack('V', $signed + 0x100000000);
        $in = new DataInputStream(new BinaryStringInputStream($data));
        $this->assertEquals($signed, $in->readIntLE());
    }
}
