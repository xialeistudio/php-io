<?php


namespace io;

/**
 * 数据转换
 * Trait ConvertTrait
 * @package io
 */
trait ConvertTrait
{
    /**
     * 无符号短整型转有符号短整形
     * @param int $short
     * @return int
     */
    public function convertUnSignedShortToSignedShort(int $short): int
    {
        if ($short > 0x7fff) {
            $short -= 0x10000;
        }
        return $short;
    }

    /**
     * 无符号整型转有符号整型
     * @param int $int
     * @return int
     */
    public function convertUnSignedIntToSignedInt(int $int): int
    {
        if ($int > 0x7fffffff) {
            $int -= 0x100000000;
        }
        return $int;
    }

    /**
     * 有符号转无符号
     * @param int $short
     * @return int
     */
    public function convertSignedShortToUnSignedShort(int $short): int
    {
        if ($short < 0) {
            $short += 0x10000;
        }
        return $short;
    }

    /**
     * 有符号整型转无符号整型
     * @param int $int
     * @return int
     */
    public function convertSignedIntToUnSignedInt(int $int): int
    {
        if ($int < 0) {
            $int+=0x100000000;
        }
        return $int;
    }
}