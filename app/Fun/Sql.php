<?php

namespace App\Fun;

use App\Fun\__;

class Sql
{
    /**
     * getUsers2CreateOrder
     *
     * @param  $count_flag
     * @return string
     */
    public static function getUsers2CreateOrder($count_flag = false)
    {
        $sql = "select CONCAT(name, ' - ', phone) as name,
                       users.id                   as id
                  from users
                  left join status_user
                    on status_user.id_user        = users.id
                 where users.del_flag             = 0
                   and status_user.id_status      = 1
                 order by users.name";
        return $count_flag ? $sql : $sql . " " . "limit :limit offset :offset";
    }

    /**
     * getUsers4IndexUser
     *
     * @param  $count_flag
     * @return string
     */
    public static function getUsers4IndexUser($count_flag = false)
    {
        $sql = "select users.id                                                                   as id,
                       users.name                                                                 as name,
                       users.email                                                                as email,
                       users.path                                                                 as path,
                       if(users.gender = 1, '".__::GENDER['MALE']."', '".__::GENDER['FEMALE']."') as 'gender',
                       users.birthdate                                                            as birthdate,
                       users.identity_card                                                        as identity_card,
                       users.phone                                                                as phone,
                       status.name                                                                as status
                  from users
                  left join status_user
                    on status_user.id_user                                                        = users.id
                  left join status
                    on status.id                                                                  = status_user.id_status
                 where users.del_flag                                                             = 0
                 order by users.name asc";
        return $count_flag ? $sql : $sql . " " . "limit :limit offset :offset";
    }
}
