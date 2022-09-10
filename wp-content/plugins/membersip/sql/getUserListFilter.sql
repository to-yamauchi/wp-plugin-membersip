 with user_list as ( 
    select
        JSON_UNQUOTE(JSON_EXTRACT(value, '$.userid')) as ユーザーID
        , JSON_UNQUOTE(JSON_EXTRACT(value, '$.loginid[0].data')) as ログインID
        , JSON_UNQUOTE(JSON_EXTRACT(value, '$.password[0].data')) as パスワード
        , JSON_UNQUOTE(JSON_EXTRACT(value, '$.sei[0].data')) as 姓
        , JSON_UNQUOTE(JSON_EXTRACT(value, '$.mei[0].data')) as 名
        , JSON_UNQUOTE(JSON_EXTRACT(value, '$.tel[0].data')) as 電話番号
        , JSON_UNQUOTE(JSON_EXTRACT(value, '$.mail[0].data')) as メール
        , JSON_UNQUOTE(JSON_EXTRACT(value, '$.gender[0].data')) as 性別
        , JSON_EXTRACT(value, '$.del_flg[0].data') as 削除
    from
        t_t_user_info
    where 
        del_flg = %d or del_flg = %d
) 
, filter as ( 
    select
        * 
    from
        user_list 
    where
        ユーザーID like %s
        and ログインID like %s 
        and パスワード like %s 
        and 姓 like %s
        and 名 like %s 
        and 電話番号 like %s
        and メール like %s 
        and 性別 like %s
) 
select
    * 
from
    filter 
order by
    ユーザーID;