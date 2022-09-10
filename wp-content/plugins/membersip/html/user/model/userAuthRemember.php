<?php

class MembersipUserAuthRemember {

    function __construct() {}

    /**
     * リメンバーページ画面の切り替え
     */
    static public function showPage(){

        global $post;
        global $server_json;
        
        // POSTデータをJSON化
        $post        = json_decode(json_encode($_POST));
        $server_json = json_decode(json_encode($_SERVER));

        if ($post->type == "remember") {
            
            self::memberCheck();
            return;
        }

        // リメンバー画面を表示
        self::userRemember();
    }

    /**
     * 
     */
    static private function userRemember($ERROR = array()) {

        global $membersip_html_path;
        global $error;

        try{

            // エラーが存在する場合は、設定
            $error = array();
            if (count($ERROR) > 0){
                $error = json_decode(json_encode($ERROR));
            }
            
            // 編集完了画面
            include($membersip_html_path.'user/view/page-remember.php');

        } catch (Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }

    /**
     * ユーザー登録画面の表示
     */
    static private function remember() {

        global $membersip_sql_path;
        global $post;

        // DBにてユーザーが存在するかチェック
        try {
            
            $member = file_get_contents($membersip_sql_path.'getMember.sql');
            $Database = new Database();
            $Database->select($member, array($post->mail, $post->tel));
            return $Database->getResult();

        } catch (Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }

    /**
     * 
     */
    static private function memberCheck(){
        
        global $post;

        try{

            // メールの未入力・フォーマットチェック
            if (MembersipValidation::isError($post)){

                // リメンバー画面を表示
                self::userRemember();
                return;
            }

            // ユーザー情報を取得
            $ret = self::remember();
            $loginData = "";
            $count = 1;
            foreach($ret as $key => $value) {
                $loginData .= "    ログイン情報[".$count++."]　" . $value->loginid . "（" . $value->password . "）\n";
            }
            $loginData = trim($loginData, ' \t');

            $login_info = <<<HEREDOC
◆ログイン情報

　サンプル：ログインID（ログインパスワード）
---------------------------------------
{$loginData}
---------------------------------------
HEREDOC;

            // メールを送信（パスワード）
            MembersipMail::sendMail(
                't-yamauchi@unhork.com' , 
                array(
                    array("email" => $post->mail)
                ),
                'ログイン情報について' ,
                $login_info
            );

        } catch (Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }
}