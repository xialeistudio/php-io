# php-io

易用的PHP二进制操作工具库。

如你所知,PHP自带的 `pack`/`unpack` 对用户来说是不友好的，有挺多数据类型定义需要记忆，这就是开发本项目的原因。

你可以使用本库开发类似ES、Redis、Memcached、Kafka等服务器的客户端。

## 安装

```
composer require xialeistudio/io
```

## 功能
+ 二进制字符串操作
+ 文件操作(本地文件、Sockets等等)

## 支持的数据类型

|类型|别名|字节数|
|:---:|:---:|:---:|
|unsigned char|uint8|1|
|signed char|int8|1|
|unsigned short|uint16|2|
|signed short|int16|2|
|unsigned int|uint32|4|
|signed int|int32|4|
|string|-|-|

> 所有数据类型都支持大端序(Big Endian)和小端序(Little Endian)

## 示例

### 二进制字符串示例

> 本示例展示使用内存中的二进制字符串来存取二进制数据。

```php
<?php
use io\BinaryStringInputStream;
use io\BinaryStringOutputStream;
use io\DataInputStream;
use io\DataOutputStream;

require __DIR__.'/vendor/autoload.php';

// 使用二进制输出流作为底层，你可以替换为文件流
$out = new BinaryStringOutputStream();
// 包装底层输出流为数据输出流，除了字节之外，可以输出指定类型的数据（数字，字符串等）
$dataOut = new DataOutputStream($out);
$dataOut->writeUnSignedIntBE(0x12345678);
$dataOut->writeUnSignedShortBE(0x1234);
$dataOut->writeString('hello');

// 输出最终数据到二进制字符串
// 16进制数据: 0x12 0x34 0x56 0x78 0x12 0x34 0x68 0x65 0x6c 0x6c 0x6f
$data = $out->toBinaryString(); 

// 从二进制字符串新建输入流，你可以替换为文件流
$in = new DataInputStream(new BinaryStringInputStream($data));
$int = $in->readUnSignedIntBE(); // 16进制: 0x12 0x34 0x56 0x78
$short = $in->readUnSignedShortBE(); // 16进制: 0x12 0x34
$string = $in->readString(5); // 5字节字符串, 内容是 'hello'
``` 

### 文件操作示例

> 本示例展示跟服务器进行二进制数据收发

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

// 本示例使用了私有协议通信
// 包装底层的文件输出流为数据输出流，获得多格式数据操作能力
$out = new DataOutputStream(new FileOutputStream($client));
// 包头
$out->writeUnSignedShortBE(0xcafe); // magic number
$out->writeUnSignedShortBE(0x0001); // version number
$out->writeUnSignedIntBE(0x00000007); // body length 2字节opcode + 5字节内容
// 包体
$out->writeUnSignedShortBE(0x0001); // opcode
$out->writeString('hello');
$out->flush();

// 读取服务器响应
$in = new DataInputStream(new FileInputStream($client));
$magicNumber = $in->readUnSignedShortBE(); // magic number
$versionNumber = $in->readUnSignedShortBE(); // version number
$bodyLength = $in->readUnSignedIntBE(); // body length;
$opcode = $in->readUnSignedShortBE(); // opcode
$string = $in->readString($bodyLength - $opcode);
``` 

### Kafka Metadata Request示例

`examples/get_kafka_brokers.php` 展示了kafka二进制协议交互。