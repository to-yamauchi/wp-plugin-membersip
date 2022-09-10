<?php

class MembersipInit {

    function __construct() {}

    static public function execute() {

        global $membersip_sql_path;

        // テーブル作成SQLの読み込み
        try {
            $cre_t_m_config    = file_get_contents($membersip_sql_path.'/cre_t_m_config.sql');
            $cre_t_t_log       = file_get_contents($membersip_sql_path.'/cre_t_t_log.sql');
            $cre_t_t_user_info = file_get_contents($membersip_sql_path.'/cre_t_t_user_info.sql');

            $init_t_m_config = file_get_contents($membersip_sql_path.'/init_t_m_config.sql');
        
            // 実行
            $Database = new Database();
            $Database->create($cre_t_m_config, array());
            $Database->create($cre_t_t_log, array());
            $Database->create($cre_t_t_user_info, array());
            $Database->create($init_t_m_config, array());
            
        } catch(Exception $e) {
            throw new Exception($e);
        }
    }
}