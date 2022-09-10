select
    *
FROM
    t_m_config 
WHERE
    p_code = %s
    and m_code = %d
    and s_code = %d
;