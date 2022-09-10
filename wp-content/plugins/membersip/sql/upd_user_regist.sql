update t_t_user_info 
set
    value = JSON_SET(value, '$.userid', %s) 
where
    id = %d
;