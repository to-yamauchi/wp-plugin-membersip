create table t_t_user_info( 
    id SERIAL PRIMARY KEY
    , value json DEFAULT NULL
    , userid varchar(10) GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(value, '$.userid'))) VIRTUAL
    , loginid varchar(50) GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(value, '$.loginid[0].data'))) VIRTUAL
    , password varchar(50) GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(value, '$.password[0].data'))) VIRTUAL
    , del_flg boolean GENERATED ALWAYS AS (JSON_EXTRACT(value, '$.del_flg[0].data')) VIRTUAL
    ,UNIQUE KEY idx_userid_class (userid)
    ,UNIQUE KEY idx_loginid_class (loginid)
    ,KEY idx_userid (userid) 
);