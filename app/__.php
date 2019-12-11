<?php

namespace App;

class __
{
    /**
     * [public description]
     * @var [type]
     */
    public static $RE_NAME = '/[^ A-Za-z0-9_ăâêôơưĂÂÊÔƠƯáắấéếíýóốớúứÁẮẤÉẾÍÝÓỐỚÚỨàằầèềìỳòồờùừÀẰẦÈỀÌỲÒỒỜÙỪảẳẩẻểỉỷỏổởủửẢẲẨẺỂỈỶỎỔỞỦỬãẵẫẽễĩỹõỗỡũữÃẴẪẼỄĨỸÕỖỠŨỮ]| {2}/i';
    public static $RE_IDENTITY_CARD = '/[^0-9]|[0-9]{10}/m';
    public static $RE_GENDER = '/[^0-1]/m';
    public static $RE_PHONE = '/[^0-9]|[0-9]{12}/m';
    public static $RE_EMAIL = '/[^0-9a-zA-Z_\.\@]/i';

    /**
     * [public description]
     * @var [type]
     */
    public static $ROLES = ['ADMIN' => 1, 'USER' => 2];

    /**
     * [public description]
     * @var [type]
     */
    public static $TAKE_ITEM = 15;

    /**
     * [public description]
     * @var [type]
     */
    public static $STATUS = ['active', 'locked'];

    /**
     * [public description]
     * @var [type]
     */
    public static $VALIDATES = [
      'email' => 'Email không sẵn sàn vì nó đã được sử dụng',
      'identity_card' => 'CMND không sẵn sàn vì nó đã được sử dụng',
      'phone' => 'Số điện thoại không sẵn sàn vì nó đã được sử dụng'
    ];

    /**
     * [public description]
     * @var [type]
     */
    public static $MESSAGES = [
      'status' => 'Đã thay đổi trạng thái',
      'success' => 'Thêm mới thành công',
      'update' => 'Cập nhật thành công',
      'delete' => 'Đã xóa thành công',
      'errors' => [
        'pays' => [
          'Phần trăm không được rỗng',
          'Phần trăm đã được cài đặt',
          'Phần trăm đang được sử dụng'
        ],
        'roles' => [
          'Tên nhóm người dùng không được rỗng'
        ],
        'users' => [
          'Họ và tên không hợp lệ',
          'Số chứng minh nhân dân không hợp lệ',
          'Giới tính không hợp lệ',
          'Ngày sinh không hợp lệ',
          'Số điện thoại không hợp lệ',
          'Mật khẩu không hợp lệ',
          'Email không hợp lệ'
        ]
      ]
    ];
}
