<?php

namespace App\Fun;

class Validate
{
    /**
     * message
     *
     * @param  $key
     * @return string
     */
    public static function message($key)
    {
        $__ = [
          'email' => 'Email không sẵn sàn vì nó đã được sử dụng',
          'identity_card' => 'CMND không sẵn sàn vì nó đã được sử dụng',
          'phone' => 'Số điện thoại không sẵn sàn vì nó đã được sử dụng',
          'quantity' => 'Số lượng phải là số nguyên dương'
        ];
        return $__[$key];
    }

    /**
     * regular
     *
     * @param  $key
     * @return string
     */
    public static function reg($key)
    {
        $__ = [
            'NAME' => '/[^ A-Za-z0-9_ăâêôơưĂÂÊÔƠƯáắấéếíýóốớúứÁẮẤÉẾÍÝÓỐỚÚỨàằầèềìỳòồờùừÀẰẦÈỀÌỲÒỒỜÙỪảẳẩẻểỉỷỏổởủửẢẲẨẺỂỈỶỎỔỞỦỬãẵẫẽễĩỹõỗỡũữÃẴẪẼỄĨỸÕỖỠŨỮạặậẹệịỵọộợụựẠẶẬẸỆỊỴỌỘỢỤỰ]| {2}/i',
            'IDENTITY_CARD' => '/[^0-9]|[0-9]{10}/m',
            'GENDER' => '/[^0-1]/m',
            'PHONE' => '/[^0-9]|[0-9]{12}/m',
            'EMAIL' => '/[^0-9a-zA-Z_\.\@]/i',
            'ALPHABET' => '/[^ A-Za-z_ăâêôơưĂÂÊÔƠƯáắấéếíýóốớúứÁẮẤÉẾÍÝÓỐỚÚỨàằầèềìỳòồờùừÀẰẦÈỀÌỲÒỒỜÙỪảẳẩẻểỉỷỏổởủửẢẲẨẺỂỈỶỎỔỞỦỬãẵẫẽễĩỹõỗỡũữÃẴẪẼỄĨỸÕỖỠŨỮạặậẹệịỵọộợụựẠẶẬẸỆỊỴỌỘỢỤỰ]| {2}/i',
            'QUANTITY' => '/[^0-9]/'
        ];
        return $__[$key];
    }
}
