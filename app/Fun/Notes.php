<?php

namespace App\Fun;

class Notes
{
    /**
     * order
     *
     * @param  $key
     * @param  $code
     * @param  $user
     * @param  $date_time
     * @return string
     */
    public static function order($key, $code = '{0}', $user = '{1}', $date_time = '{2}')
    {
        $__ = [
          'create'  => 'đơn hàng '.$code.' được tạo bởi '.$user.' vào lúc '.$date_time,
          'updated' => 'đơn hàng '.$code.' được cập nhật thông tin bởi '.$user.' vào lúc '.$date_time
        ];
        return $__[$key];
    }

    /**
     * trace
     *
     * @param  $key
     * @param  $code
     * @param  $date_time
     * @return string
     */
    public static function trace($key, $code = '{0}', $date_time = '{1}')
    {
        $__ = [
          'create'  => 'đơn hàng '.$code.' tạo vào '.$date_time,
          'updated' => 'đơn hàng '.$code.' được cập nhật thông tin vào '.$date_time
        ];
        return $__[$key];
    }
}
