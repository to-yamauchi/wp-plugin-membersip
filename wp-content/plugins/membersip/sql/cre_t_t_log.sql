create table t_t_log (
    type varchar(5)
    , uid char(13)
    , server_value json DEFAULT NULL
    , session_value json DEFAULT NULL
    , post_value json DEFAULT NULL
    , etc_value json DEFAULT NULL
    , ins_time timestamp DEFAULT CURRENT_TIMESTAMP
    ,KEY idx_type (type) 
);