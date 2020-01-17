# php-io

user-friendly binary data operation library.

As you know, `pack`/`unpack` is not user-friendly to operate binary data, so that's why this project developed.

You can use this project to develop binary protocol client(eg. kafka, memcached, etc...)

中文文档[README-CN.md]

## Install

```
composer require xialeistudio/io
```

## Features

+ Operate binary string
+ Operate file resource(eg. File, Sockets, etc.)

## Supported Data Types

|Type|Alias|Byte Length|
|:---:|:---:|:---:|
|unsigned char|uint8|1|
|signed char|int8|1|
|unsigned short|uint16|2|
|signed short|int16|2|
|unsigned int|uint32|4|
|signed int|int32|4|
|string|-|-|

> all numbers support big endian and little endian

## Examples

### BinaryString Example

> This example simply operate data with binary string in memory.

```php
<?php
use io\BinaryStringInputStream;
use io\BinaryStringOutputStream;
use io\DataInputStream;
use io\DataOutputStream;

require __DIR__.'/vendor/autoload.php';

// use binary string as underlying stream, you can simply change to FileOutputStream.
$out = new BinaryStringOutputStream();
// wrap underlying stream, so you can operate many data types instead of byte.
$dataOut = new DataOutputStream($out);
$dataOut->writeUnSignedIntBE(0x12345678);
$dataOut->writeUnSignedShortBE(0x1234);
$dataOut->writeString('hello');

// output final binary data
// hex data: 0x12 0x34 0x56 0x78 0x12 0x34 0x68 0x65 0x6c 0x6c 0x6f
$data = $out->toBinaryString(); 

// create data input stream from binary stream data, you can simply change to FileInputStream.
$in = new DataInputStream(new BinaryStringInputStream($data));
$int = $in->readUnSignedIntBE(); // hex data: 0x12 0x34 0x56 0x78
$short = $in->readUnSignedShortBE(); // hex data: 0x12 0x34
$string = $in->readString(5); // read 5 chars, $string is 'hello'
``` 

### FileStream Example

> This example simply send/receive binary data with socket connection.

```php
<?php
use io\DataInputStream;
use io\DataOutputStream;
use io\FileInputStream;
use io\FileOutputStream;

$client = stream_socket_client('tcp://127.0.0.1:10000', $errno, $errstr);
if($errno) {
    die($errstr);
}

// send binary data to server, this example use a private protocol.
// wrap socket resource
$out = new DataOutputStream(new FileOutputStream($client));
// write header part
$out->writeUnSignedShortBE(0xcafe); // magic number
$out->writeUnSignedShortBE(0x0001); // version number
$out->writeUnSignedIntBE(0x00000007); // body length 2 bytes opcode + 5 bytes string
// write body part
$out->writeUnSignedShortBE(0x0001); // opcode
$out->writeString('hello'); // 5 bytes string
$out->flush();

// receive response from server
$in = new DataInputStream(new FileInputStream($client));
$magicNumber = $in->readUnSignedShortBE(); // magic number
$versionNumber = $in->readUnSignedShortBE(); // version number
$bodyLength = $in->readUnSignedIntBE(); // body length;
$opcode = $in->readUnSignedShortBE(); // opcode
$string = $in->readString($bodyLength - $opcode);
``` 

### Kafka Metadata Request

`examples/get_kafka_brokers.php` show how to communicate with kafka.