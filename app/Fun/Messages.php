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
     * @return string
     */
    public static function success()
    {
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
     * @return string
     */
    public static function cancel($content = '')
    {
        return 'Đã hủy '.$content.' thành công';
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
          'phone'    => 'Số điện thoại không hợp lệ'
        ];
        return $__[$key];
    }
}
