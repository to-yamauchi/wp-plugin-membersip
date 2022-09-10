select
    *
FROM
    t_t_user_info
WHERE
    loginid = %s
    and del_flg = false
;