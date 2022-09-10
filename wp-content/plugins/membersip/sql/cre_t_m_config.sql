create table t_m_config( 
    p_code char (10)
    , m_code varchar (30)
    , s_code varchar (30)
    , value text
    , valid_from int(8) DEFAULT 19000101
    , valid_to int(8) DEFAULT 29991231
    , remark varchar (255)
    , upd_time timestamp DEFAULT CURRENT_TIMESTAMP 
        ON UPDATE CURRENT_TIMESTAMP
    ,UNIQUE KEY idx_pcode_mcode_class (p_code, m_code, s_code)
    ,PRIMARY KEY(p_code, m_code, s_code)
);