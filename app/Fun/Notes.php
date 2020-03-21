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
     * @param  $shipper
     * @return string
     */
    public static function order($key, $code = '{0}', $user = '{1}', $date_time = '{2}', $shipper = '{3}')
    {
        $__ = [
          'create'    => 'đơn hàng '.$code.' được tạo bởi '.$user.' vào lúc '.$date_time,
          'updated'   => 'đơn hàng '.$code.' được cập nhật thông tin bởi '.$user.' vào lúc '.$date_time,
          'assign'    => 'đơn hàng '.$code.' được phân công cho '.$shipper.' vận chuyển bởi '.$user.' vào lúc '.$date_time,
          'pack'      => 'đơn hàng '.$code.' được cập nhật đóng gói xong bởi '.$user.' vào lúc '.$date_time,
          'shipping'  => 'đơn hàng '.$code.' được cập nhật đang vận chuyển bởi '.$user.' vào lúc '.$date_time,
          'success'   => 'đơn hàng '.$code.' được cập nhật vận chuyển thành công bởi '.$user.' vào lúc '.$date_time,
          'cancel'    => 'đơn hàng '.$code.' được cập nhật đã hủy bởi '.$user.' vào lúc '.$date_time,
          'rollback'  => 'đơn hàng '.$code.' được cập nhật chuyển lại bởi '.$user.' vào lúc '.$date_time,
          'pending'   => 'đơn hàng '.$code.' được cập nhật tạm dừng bởi '.$user.' vào lúc '.$date_time,
          'pay'       => 'đơn hàng '.$code.' được cập nhật đã thanh toán bởi '.$user.' vào lúc '.$date_time,
          'transfers' => 'đơn hàng '.$code.' được cập nhật đã chuyển tiền bởi '.$user.' vào lúc '.$date_time
        ];
        return $__[$key];
    }

    /**
     * trace
     *
     * @param  $key
     * @param  $code
     * @param  $date_time
     * @param  $shipper
     * @return string
     */
    public static function trace($key, $code = '{0}', $date_time = '{1}', $shipper = '{2}')
    {
        $__ = [
          'create'    => 'đơn hàng '.$code.' tạo vào '.$date_time,
          'updated'   => 'đơn hàng '.$code.' được cập nhật thông tin vào '.$date_time,
          'assign'    => 'đơn hàng '.$code.' được phân công cho '.$shipper.' vận chuyển vào lúc '.$date_time,
          'pack'      => 'đơn hàng '.$code.' được đóng gói xong vào lúc '.$date_time,
          'shipping'  => 'đơn hàng '.$code.' được đang vận chuyển vào lúc '.$date_time,
          'success'   => 'đơn hàng '.$code.' được vận chuyển thành công vào lúc '.$date_time,
          'cancel'    => 'đơn hàng '.$code.' được đã hủy vào lúc '.$date_time,
          'rollback'  => 'đơn hàng '.$code.' được chuyển lại vào lúc '.$date_time,
          'pending'   => 'đơn hàng '.$code.' được tạm dừng vào lúc '.$date_time,
          'pay'       => 'đơn hàng '.$code.' đã được thanh toán vào lúc '.$date_time,
          'transfers' => 'đơn hàng '.$code.' đã được chuyển tiền vào lúc '.$date_time
        ];
        return $__[$key];
    }

    /**
     * balance_log
     * @param  $key
     * @param  $code
     * @param  $date_time
     * @param  $shipper
     * @param  $pay
     * @return string
     */
    public static function balance_log($key, $code='{0}', $date_time='{1}', $shipper = '{2}', $pay ='{3}')
    {
        $__ = [
          'create' => 'đã chuyển tiền '.$pay.' VND theo đơn hàng '.$code. ' cho '.$shipper
        ];
        return $__[$key];
    }
}
