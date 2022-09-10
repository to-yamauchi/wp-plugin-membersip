SELECT
    *
FROM
    t_m_config 
WHERE
    p_code = 'P001001001'
    and m_code = 'validation'
    and s_code = 1
    and (
    valid_from >= DATE_FORMAT(current_date, '%Y%m%d')
    or DATE_FORMAT(current_date, '%Y%m%d') <= valid_to
    )
;