<?php

namespace App\Fun;

class Messages
{
    /**
     * errors
     *
     * @return Messages
     */
    public static function errors()
    {
        return new Messages;
    }

    /**
     * status
     *
     * @return string
     */
    public static function status()
    {
        return 'Đã thay đổi trạng thái';
    }

    /**
     * success
     *
     * @param  $code
     * @return string
     */
    public static function success($code = '{1}')
    {
        if ($code != '{1}') {
            return 'Đơn hàng '.$code.' được vận chuyển thành công';
        }
        return 'Thêm mới thành công';
    }

    /**
     * update
     *
     * @return string
     */
    public static function update()
    {
        return 'Cập nhật thành công';
    }

    /**
     * delete
     *
     * @return string
     */
    public static function delete()
    {
        return 'Đã xóa thành công';
    }

    /**
     * cancel
     *
     * @param  $content
     * @param  $code
     * @return string
     */
    public static function cancel($content = '', $code = '{1}')
    {
        if ($code != '{1}') {
            return 'Đơn hàng '.$code.' đã được hủy';
        }
        return 'Đã hủy '.$content.' thành công';
    }

    /**
     * assign
     *
     * @param  $code
     * @param  $shipper
     * @return string
     */
    public static function assign($code = '{1}', $shipper = '{2}')
    {
        return 'Đơn hàng '.$code.' được phân công cho '.$shipper.' vận chuyển';
    }

    /**
     * pack
     *
     * @param  $code
     * @return string
     */
    public static function pack($code = '{1}')
    {
        return 'Đơn hàng '.$code.' được đóng gói xong';
    }

    /**
     * shipping
     *
     * @param  $code
     * @return string
     */
    public static function shipping($code = '{1}')
    {
        return 'Đơn hàng '.$code.' đang được vận chuyển';
    }

    /**
     * rollback
     *
     * @param  $code
     * @return string
     */
    public static function rollback($code = '{1}')
    {
        return 'Đơn hàng '.$code.' được phân công chuyển lại';
    }

    /**
     * pending
     *
     * @param  $code
     * @return string
     */
    public static function pending($code = '{1}')
    {
        return 'Đơn hàng '.$code.' tạm dừng vận chuyển';
    }

    /**
     * pay
     *
     * @param  $code
     * @return string
     */
    public static function pay($code = '{1}')
    {
        return 'Đơn hàng '.$code.' đã được thanh toán';
    }

    /**
     * transfers
     *
     * @param  $code
     * @return string
     */
    public static function transfers($code = '{1}')
    {
        return 'Đơn hàng '.$code.' đã được chuyển tiền vận chuyển';
    }

    /**
     * code 500
     *
     * @return string
     */
    public function _500()
    {
        return 'Xảy ra lỗi không xác định';
    }

    /**
     * users
     *
     * @param  $key
     * @return string
     */
    public function users($key)
    {
        $__ = [
          'name'          => 'Họ và tên không hợp lệ',
          'identity_card' => 'Số chứng minh nhân dân không hợp lệ',
          'gender'        => 'Giới tính không hợp lệ',
          'birthdate'     => 'Ngày sinh không hợp lệ',
          'phone'         => 'Số điện thoại không hợp lệ',
          'password'      => 'Mật khẩu không hợp lệ',
          'email'         => 'Email không hợp lệ'
        ];
        return $__[$key];
    }

    /**
     * pays
     *
     * @param  $key
     * @return string
     */
    public function pays($key)
    {
        $__ = [
          'percent.require' => 'Phần trăm không được rỗng',
          'percent.unique'  => 'Phần trăm đã được cài đặt',
          'percent.use'     => 'Phần trăm đang được sử dụng'
        ];
        return $__[$key];
    }

    /**
     * roles
     *
     * @param  $key
     * @return string
     */
    public function roles($key)
    {
        $__ = [
          'name' => 'Tên nhóm người dùng không được rỗng'
        ];
        return $__[$key];
    }

    /**
     * units
     *
     * @param  $key
     * @return string
     */
    public function units($key)
    {
        $__ = [
          'name' => 'Tên đơn vị tính không hợp lệ'
        ];
        return $__[$key];
    }

    /**
     * items
     *
     * @param  $key
     * @return string
     */
    public function items($key)
    {
        $__ = [
          'item'     => 'Tên sản phẩm / dịch vụ chưa nhập',
          'unit'     => 'Đơn vị tính chưa nhập',
          'quantity' => 'Số lượng chưa nhập'
        ];
        return $__[$key];
    }

    /**
     * orders
     *
     * @param  $key
     * @return string
     */
    public function orders($key)
    {
        $__ = [
          'items'    => 'Chi tiết đơn hàng đang rỗng',
          'province' => 'Chưa chọn tỉnh thành',
          'district' => 'Chưa chọn quận huyện',
          'ward'     => 'Chưa chọn phường xã',
          'address'  => 'Địa chỉ đang rỗng',
          'kg'       => 'Giá đơn hàng chưa được chọn',
          'receiver' => 'Họ tên người nhận đang rỗng',
          'phone'    => 'Số điện thoại không hợp lệ',
          'status'   => 'Thay đổi trạng thái đơn hàng trước khi cập nhật'
        ];
        return $__[$key];
    }

    /**
     * detail_shipper
     *
     * @param  $key
     * @return string
     */
    public function detail_shipper($key)
    {
        $__ = [
          'empty' => 'Không có người chuyển hàng để chọn'
        ];
        return $__[$key];
    }
}
