<?php

namespace App\Fun;

class __
{
    /**
     * STATUS
     *
     * @var string
     */
    const STATUS = ['active', 'locked'];

    /**
     * ROLES
     *
     * @var number
     */
    const ROLES = ['ADMIN' => 1, 'USER' => 2];

    /**
     * GENDER
     *
     * @var array
     */
    const GENDER = ['FEMALE' => 'Nữ', 'MALE' => 'Nam'];

    /**
     * TAKE_ITEM
     *
     * @var number
     */
    const TAKE_ITEM = 15;

    /**
     * take_item
     *
     * @return string
     */
    public static function take_item()
    {
        return self::TAKE_ITEM;
    }

    /**
     * struuid
     *
     * @return string
     */
    public static function uuid()
    {
        $entropy = false;
        $s = uniqid('', $entropy);
        $num = hexdec(str_replace('.', '', (string)$s));
        $index = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($index);
        $out = '';
        for ($t = floor(log10($num) / log10($base)); $t >= 0; $t--) {
            $a = floor($num / pow($base, $t));
            $out = $out.substr($index, $a, 1);
            $num = $num-($a * pow($base, $t));
        }
        return $out.date('YmdHis');
    }
}
