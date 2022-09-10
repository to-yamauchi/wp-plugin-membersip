with
reset as (
    select @num:=0
)
, user_list as (
select
     JSON_UNQUOTE(JSON_EXTRACT(value, '$.userid')) as ユーザーID,
     JSON_UNQUOTE(JSON_EXTRACT(value, '$.loginid[0].data')) as ログインID,
     JSON_UNQUOTE(JSON_EXTRACT(value, '$.password[0].data')) as パスワード,
     JSON_UNQUOTE(JSON_EXTRACT(value, '$.sei[0].data')) as 姓,
     JSON_UNQUOTE(JSON_EXTRACT(value, '$.mei[0].data')) as 名,
     JSON_UNQUOTE(JSON_EXTRACT(value, '$.tel[0].data')) as 電話番号,
     JSON_UNQUOTE(JSON_EXTRACT(value, '$.mail[0].data')) as メール,
     JSON_UNQUOTE(JSON_EXTRACT(value, '$.gender[0].data')) as 性別,
     case when del_flg = 0 then false else true end as 削除
from
    t_t_user_info 
)

select user_list.* from user_list,reset order by ユーザーID;