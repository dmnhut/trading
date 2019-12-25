<?php

namespace App;

class __
{
    /**
     * $STATUS
     * @var string
     */
    public static $STATUS = ['active', 'locked'];

    /**
     * $ROLES
     * @var number
     */
    public static $ROLES = ['ADMIN' => 1, 'USER' => 2];

    /**
     * messages
     * @return __
     */
    public static function messages()
    {
        $__ = new __();
        return $__;
    }

    /**
     * status
     * @return string
     */
    public function status()
    {
        return 'Đã thay đổi trạng thái';
    }

    /**
     * success
     * @return string
     */
    public function success()
    {
        return 'Thêm mới thành công';
    }

    /**
     * update
     * @return string
     */
    public function update()
    {
        return 'Cập nhật thành công';
    }

    /**
     * delete
     * @return string
     */
    public function delete()
    {
        return 'Đã xóa thành công';
    }

    /**
     * errors
     * @return $this
     */
    public function errors()
    {
        return $this;
    }

    /**
     * users
     * @param  $key
     * @return string
     */
    public function users($key)
    {
        $__ = [
            'name' => 'Họ và tên không hợp lệ',
            'identity_card' => 'Số chứng minh nhân dân không hợp lệ',
            'gender' => 'Giới tính không hợp lệ',
            'birthdate' => 'Ngày sinh không hợp lệ',
            'phone' => 'Số điện thoại không hợp lệ',
            'password' => 'Mật khẩu không hợp lệ',
            'email' => 'Email không hợp lệ'
        ];
        return $__[$key];
    }

    /**
     * pays
     * @param  $key
     * @return string
     */
    public function pays($key)
    {
        $__ = [
            'percent.require' => 'Phần trăm không được rỗng',
            'percent.unique' => 'Phần trăm đã được cài đặt',
            'percent.use' => 'Phần trăm đang được sử dụng'
          ];
        return $__[$key];
    }

    /**
     * roles
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
     * re
     * @param  $key
     * @return string
     */
    public static function re($key)
    {
        $__ = [
            'NAME' => '/[^ A-Za-z0-9_ăâêôơưĂÂÊÔƠƯáắấéếíýóốớúứÁẮẤÉẾÍÝÓỐỚÚỨàằầèềìỳòồờùừÀẰẦÈỀÌỲÒỒỜÙỪảẳẩẻểỉỷỏổởủửẢẲẨẺỂỈỶỎỔỞỦỬãẵẫẽễĩỹõỗỡũữÃẴẪẼỄĨỸÕỖỠŨỮ]| {2}/i',
            'IDENTITY_CARD' => '/[^0-9]|[0-9]{10}/m',
            'GENDER' => '/[^0-1]/m',
            'PHONE' => '/[^0-9]|[0-9]{12}/m',
            'EMAIL' => '/[^0-9a-zA-Z_\.\@]/i'
        ];
        return $__[$key];
    }

    /**
     * take_item
     * @return string
     */
    public static function take_item()
    {
        $TAKE_ITEM = 15;
        return $TAKE_ITEM;
    }

    /**
     * validates
     * @param  $key
     * @return string
     */
    public static function validates($key)
    {
        $__ = [
          'email' => 'Email không sẵn sàn vì nó đã được sử dụng',
          'identity_card' => 'CMND không sẵn sàn vì nó đã được sử dụng',
          'phone' => 'Số điện thoại không sẵn sàn vì nó đã được sử dụng'
        ];
        return $__[$key];
    }

    /**
     * struuid
     * @return string
     */
    function struuid()
    {
        $entropy = false;
        $s=uniqid("", $entropy);
        $num= hexdec(str_replace(".", "", (string)$s));
        $index = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base= strlen($index);
        $out = '';
        for($t = floor(log10($num) / log10($base)); $t >= 0; $t--) {
            $a = floor($num / pow($base, $t));
            $out = $out.substr($index, $a, 1);
            $num = $num-($a*pow($base, $t));
        }
        return $out.date('YmdHis');
    }
}
