<?php

/**
 * 初期化処理
 */
class MembersipInit {

    function __construct() {}

    /**
     * 初期化を実施処理
     */
    static public function execute(){
	
        global $membersip_html_path;

        // 初期化処理
        try {

            MembersipInit::execute();

        } catch(Exception $e) {

            // エラーメッセージ
            $message_id = "E00001";
            include($membersip_html_path.'admin/toastr/error.php');
            throw new Exception($e);
        }

        // 正常メッセージ
        $message_id = "S00001";
        include($membersip_html_path.'admin/toastr/success.php');
        return true;
    }

    /**
     * 初期化を確認
     */
    static public function isInit() {

        global $membersip_sql_path;
        global $membersip_html_path;

        $Database = new Database();

        // 初期化チェック
        try {

            // テーブル作成SQLの読み込み
            $sql = file_get_contents($membersip_sql_path.'init_check.sql');
            $Database->select($sql);

            if (count($Database->getResult()) > 0) {
                return true;
            }
            
            return false;

        } catch(Exception $e) {

            // エラーメッセージ
            $message_id = "E00001";
            include($membersip_html_path.'admin/toastr/error.php');
            throw new Exception($e);
        }   
    }
}