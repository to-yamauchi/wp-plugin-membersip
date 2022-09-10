select
    count(*) as count
FROM
    t_t_user_info
WHERE
    loginid = %s
;