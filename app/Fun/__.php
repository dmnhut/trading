<?php

namespace App\Fun;

class __
{

   /**
    * INDEX
    *
    * @var integer
    */
    const INDEX = 1;

    /**
     * MOD
     *
     * @var integer
     */
    const MOD = 5;

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
    const TAKE_ITEM = 10;

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
     * status
     *
     * @param  $key
     * @return number
     */
    public static function status($key)
    {
        $__ = [
          'active'    => 1,
          'locked'    => 2,
          'create'    => 3,
          'pack'      => 4,
          'assign'    => 5,
          'shipping'  => 6,
          'success'   => 7,
          'cancel'    => 8,
          'rollback'  => 9,
          'pending'   => 10,
          'pay'       => 11,
          'transfers' => 12,
          'updated'   => 13
        ];
        return $__[$key];
    }

    /**
     * status_name
     *
     * @param  $key
     * @return string
     */
    public static function status_name($key)
    {
        $__ = [
          'active'    => 'hoạt động',
          'locked'    => 'đã khóa',
          'create'    => 'mới tạo',
          'pack'      => 'đóng gói',
          'assign'    => 'phân công',
          'shipping'  => 'đang chuyển',
          'success'   => 'thành công',
          'cancel'    => 'đã hủy',
          'rollback'  => 'chuyển lại',
          'pending'   => 'tạm dừng',
          'pay'       => 'đã thanh toán',
          'transfers' => 'đã chuyển tiền',
          'updated'   => 'đã chỉnh sửa'
        ];
        return $__[$key];
    }

    /**
     * get_tab
     *
     * @param  $key
     * @return string
     */
    public static function get_tab($key)
    {
        $__ = [
          'ASSIGN'    => 'tab-assign',
          'SHIPPING'  => 'tab-shipping',
          'TRANSFERS' => 'tab-transfers'
        ];
        return $__[$key];
    }

    /**
     * get_text
     *
     * @param  $key
     * @return string
     */
    public static function get_text($key)
    {
        $__ = [
          'order' => 'đơn hàng',
          'admin' => 'admin'
        ];
        return $__[$key];
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
