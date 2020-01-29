<?php

namespace App;

class Sql
{
    public static function getUsers2CreateOrder()
    {
        return "select CONCAT(name, ' - ', phone) as name,
                       users.id                   as id
                  from users
                  left join status_user
                    on status_user.id_user        = users.id
                 where users.del_flag             = 0
                   and status_user.id_status      = 1
                 order by users.name";
    }

    public static function getUsers4IndexUser()
    {
        return "select users.id                          as id,
                       users.name                        as name,
                       users.email                       as email,
                       users.path                        as path,
                       if(users.gender = 1, 'Nam', 'Nữ') as 'gender',
                       users.birthdate                   as birthdate,
                       users.identity_card               as identity_card,
                       users.phone                       as phone,
                       status.name                       as status
                  from users
                  left join status_user
                    on status_user.id_user               = users.id
                  left join status
                    on status.id                         = status_user.id_status
                 where users.del_flag                    = 0
                 order by users.name asc";
    }
}
