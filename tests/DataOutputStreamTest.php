<?php

namespace tests;

use io\BinaryStringOutputStream;
use io\DataOutputStream;
use PHPUnit\Framework\TestCase;

/**
 * Class DataOutputStreamTest
 * @date 2020/1/9
 * @author xialeistudio<xialeistudio@gmail.com>
 * @package tests
 */
class DataOutputStreamTest extends TestCase
{

    public function testWriteUnSignedShortBE()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(2, $dataOut->writeUnSignedShortBE(0xffff));

        $this->assertEquals(0xffff, unpack('v', $out->toBinaryString())[1]);
    }

    public function testWriteUnSignedIntBE()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(4, $dataOut->writeUnSignedIntBE(0xffffffff));

        $this->assertEquals(0xffffffff, unpack('N', $out->toBinaryString())[1]);
    }

    public function testWriteUnSignedIntLE()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(4, $dataOut->writeUnSignedIntLE(0xffffffff));

        $this->assertEquals(0xffffffff, unpack('N', $out->toBinaryString())[1]);
    }

    public function testClose()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertTrue($dataOut->close());
    }

    public function testWriteUnSignedChar()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(1, $dataOut->writeUnSignedChar(0xff));

        $this->assertEquals(0xff, unpack('C', $out->toBinaryString())[1]);
    }

    public function testWriteUnSignedShortLE()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(2, $dataOut->writeUnSignedShortLE(0xffff));

        $this->assertEquals(0xffff, unpack('v', $out->toBinaryString())[1]);
    }

    public function testWriteString()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(6, $dataOut->writeString('哈哈'));

        $this->assertEquals('哈哈', unpack('A6', $out->toBinaryString())[1]);
    }

    public function testFlush()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertTrue($dataOut->flush());
    }

    public function testWriteChar()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(1, $dataOut->writeChar(-1));

        $this->assertEquals(-1, unpack('c', $out->toBinaryString())[1]);
    }

    public function testWrite()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(1, $dataOut->write('a'));

        $this->assertEquals('a', $out->toBinaryString());
    }

    public function testWriteShortBE()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(2, $dataOut->writeShortBE(-100));

        $this->assertEquals(-100 + 0x10000, unpack('n', $out->toBinaryString())[1]);
    }

    public function testWriteShortLE()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(2, $dataOut->writeShortLE(-100));

        $this->assertEquals(-100 + 0x10000, unpack('v', $out->toBinaryString())[1]);
    }
    public function testWriteIntBE()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(4, $dataOut->writeIntBE(-100));

        $this->assertEquals(-100 + 0x100000000, unpack('N', $out->toBinaryString())[1]);
    }

    public function testWriteIntLE()
    {
        $out = new BinaryStringOutputStream();
        $dataOut = new DataOutputStream($out);
        $this->assertEquals(4, $dataOut->writeIntLE(-100));

        $this->assertEquals(-100 + 0x100000000, unpack('V', $out->toBinaryString())[1]);
    }
}
