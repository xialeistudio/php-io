<?php
/**
 * 读取kafka broker列表
 */
require __DIR__ . '/../vendor/autoload.php';

use io\BinaryStringInputStream;
use io\BinaryStringOutputStream;
use io\DataInputStream;
use io\DataOutputStream;
use io\FileInputStream;
use io\FileOutputStream;

$client = stream_socket_client('tcp://127.0.0.1:9092', $errno, $errstr, 5);
if ($errno) {
    die($errstr);
}


$binaryOutputStream = new BinaryStringOutputStream();
$binaryPacketOutput = new DataOutputStream($binaryOutputStream);
$binaryPacketOutput->writeUnSignedShortBE(0x03); // METADATA_REQUEST
$binaryPacketOutput->writeUnSignedShortBE(1); // API_VERSION
$binaryPacketOutput->writeUnSignedIntBE(0x01); // REQUEST_ID
$binaryPacketOutput->writeUnSignedShortBE(strlen('test')); // CLIENT_ID length
$binaryPacketOutput->writeString('test'); // CLIENT_ID
$binaryPacketOutput->writeUnSignedIntBE(1); // TOPIC_ARRAY count
// TOPIC LIST
$binaryPacketOutput->writeUnSignedShortBE(strlen('test1'));
$binaryPacketOutput->writeString('test1');
$binaryPacketOutput->flush();
$packet = $binaryOutputStream->toBinaryString();

$out = new DataOutputStream(new FileOutputStream($client));
$out->writeUnSignedIntBE(strlen($packet)); // 4字节包长度
$out->write($packet); // 包体
$out->flush(); // 输出到Socket

$in = new DataInputStream(new FileInputStream($client));
$size = $in->readUnSignedIntBE(); // 4字节包长度

$in = new DataInputStream(new BinaryStringInputStream(fread($client, $size)));
fclose($client);

$requestId = $in->readUnSignedIntBE(); // 4字节请求ID
printf("packet length: %d requestId: %d\n", $size, $requestId);

$brokerCount = $in->readUnSignedIntBE(); // broker数量
for ($i = 0; $i < $brokerCount; $i++) { // 循环读取broker
    $nodeId = $in->readUnSignedIntBE(); // nodeId
    $hostLength = $in->readUnSignedShortBE(); // host长度
    $host = $in->readString($hostLength); // host
    $port = $in->readUnSignedIntBE(); // port
    $rackLength = $in->readShortBE(); // rack
    $rack = null;
    if ($rackLength != -1) {
        $rack = $in->readString($rackLength);
    }
    printf("nodeId:%d host:%s port:%d rack: %s\n", $nodeId, $host, $port, $rack);
}
$controllerId = $in->readUnSignedIntBE();
printf("controllerId: %d\n", $controllerId);
$topicCount = $in->readUnSignedIntBE();
printf("topic count %d\n", $topicCount);


for ($i = 0; $i < $topicCount; $i++) {
    printf("----topic list----\n");
    $errCode = $in->readUnSignedShortBE();
    $nameLength = $in->readUnSignedShortBE();
    $name = $in->readString($nameLength);
    $isInternal = $in->readUnSignedChar();
    printf("errcode: %d name: %s interval: %d\n", $errCode, $name, $isInternal);

    $partitionCount = $in->readUnSignedIntBE();
    printf("----topic [%s] partition list count %d---\n", $name, $partitionCount);
    for ($j = 0; $j < $partitionCount; $j++) {
        $errCode = $in->readUnSignedShortBE();
        $partitionIndex = $in->readUnSignedIntBE();
        $leaderId = $in->readUnSignedIntBE();
        $replicaNodesCount = $in->readUnSignedIntBE();
        $replicaNodes = [];
        for ($k = 0; $k < $replicaNodesCount; $k++) {
            $replicaNodes[] = $in->readUnSignedIntBE();
        }
        $isrNodeCount = $in->readUnSignedIntBE();
        $isrNodes = [];
        for ($k = 0; $k < $isrNodeCount; $k++) {
            $isrNodes[] = $in->readUnSignedIntBE();
        }
        printf(
            "errcode: %d partitionIndex: %d leaderId: %d replicaNodes: [%s] isrNodes: [%s]\n",
            $errCode,
            $partitionIndex,
            $leaderId,
            join(',', $replicaNodes),
            join(',', $isrNodes)
        );
    }
}