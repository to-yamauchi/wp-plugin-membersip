select
    *
FROM
    t_m_user_config 
WHERE
    p_code = %s
    and m_code = %d
    and s_code = %d
;