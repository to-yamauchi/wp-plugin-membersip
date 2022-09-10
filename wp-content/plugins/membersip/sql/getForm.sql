select
    t1.value as item,
    t2.value as name,
    t3.value as type,
    t4.value as sort
from
    ( 
        select
            * 
        from
            t_m_user_config 
        where
            p_code = 'P001001001' 
            and m_code = 'input_view'
            and (valid_from >= cast(current_date as integer)
            or cast(current_date as integer) <= valid_to)
    ) t1 
    left join ( 
        select
            * 
        from
            t_m_user_config 
        where
            p_code = 'P001001001' 
            and m_code = 'input_name'
            and (valid_from >= cast(current_date as integer)
            or cast(current_date as integer) <= valid_to)
    ) t2 
        on t1.s_code = t2.s_code 
    left join ( 
        select
            * 
        from
            t_m_user_config 
        where
            p_code = 'P001001001' 
            and m_code = 'input_type'
            and (valid_from >= cast(current_date as integer)
            or cast(current_date as integer) <= valid_to)
    ) t3 
        on t1.s_code = t3.s_code
    left join ( 
        select
            * 
        from
            t_m_user_config 
        where
            p_code = 'P001001001' 
            and m_code = 'input_sort'
            and (valid_from >= cast(current_date as integer)
            or cast(current_date as integer) <= valid_to)
    ) t4 
        on t1.s_code = t4.s_code
order by t4.value asc
;