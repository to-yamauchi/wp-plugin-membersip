<?php

class MembersipUserRegist {

    function __construct() {}

    /**
     * ユーザー登録画面の切り替え
     * @return void
     */
    static public function showPage():void {
        
        global $post;
        global $server_json;

        // POSTデータをJSON化
        $post   =  json_decode(json_encode($_POST, JSON_UNESCAPED_UNICODE));
        $server_json = json_decode(json_encode($_SERVER, JSON_UNESCAPED_UNICODE));

        // ユーザー登録フォームより確認へ
        if ($post->type == "user-regist") {
            self::userConfirm();
            return;
        }

        // ユーザー登録確認フォームより入力画面へ戻った場合
        if ($post->type == "user-regist-confirm" && $post->trans == "戻る") {
            self::userRegist();
            return;
        }

        // ユーザー登録確認フォームより完了へ
        if ($post->type == "user-regist-confirm" && $post->trans == "登録") {
            self::userRegistEnd();
            return;
        }

        // デフォルトページ
        self::userRegist();
        return;
    }

    /**
     * ユーザー登録画面の表示
     * @return void
     */
    static private function userRegist():void {

        global $membersip_html_path;
        include($membersip_html_path.'user/view/page-user-regist.php');
    }

    
    /**
     * ユーザー登録確認画面の表示
     * @return void
     */
    static private function userConfirm():void {

        global $membersip_html_path;
        global $post;

        try{

            MembersipSession::setSession('regist', $post);

            // チェックに対するエラー内容を登録
            if (MembersipValidation::isError($post)){

                self::userRegist();
                return;
            }

            include($membersip_html_path.'user/view/page-user-regist-confirm.php');

        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        } 
    }


    /**
     * ユーザー登録完了画面
     * @return void
     */
    static public function userRegistEnd():void {

        try{
            global $membersip_html_path;

            // ユーザー登録でエラーの場合は、戻す
            if (MembersipUserRegister::execute() == false) {
                self::userRegist();
                return;
            }

            include($membersip_html_path.'user/view/page-user-regist-end.php');

        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }
}