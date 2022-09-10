select
    * 
from
    t_t_user_info 
where
    JSON_EXTRACT(value, '$.mail[0].data') = %s
    and JSON_EXTRACT(value, '$.tel[0].data') = %s
    and del_flg = false
;