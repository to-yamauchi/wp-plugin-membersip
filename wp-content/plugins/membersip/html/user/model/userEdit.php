<?php

class MembersipUserEdit {

    function __construct() {}

    /**
     * ユーザー登録画面の切り替え
     * @return void
     */
    static public function showPage():void {
        
        global $post;
        global $server_json;

        // POSTデータをJSON化
        $post        = json_decode(json_encode($_POST, JSON_UNESCAPED_UNICODE));
        $server_json = json_decode(json_encode($_SERVER, JSON_UNESCAPED_UNICODE));

        // ユーザー登録フォームより確認へ
        if ($post->type == "user-edit") {
            self::userConfirm();
            return;
        }

        // ユーザー登録確認フォームより入力画面へ戻った場合
        if ($post->type == "user-edit-confirm" && $post->trans == "戻る") {
            self::userEdit();
            return;
        }

        // ユーザー登録確認フォームより完了へ
        if ($post->type == "user-edit-confirm" && $post->trans == "登録") {
            self::userEditEnd();
            return;
        }

        // ページ情報が
        self::userEdit();
        return;
    }


    /**
     * ユーザー編集確認画面の表示
     * @return void
     */
    static private function userConfirm():void {

        global $membersip_html_path;
        global $post;

        try{
           
            // 編集内容をセッションへ登録
            MembersipSession::setSession('edit', $post);

            // チェックに対するエラー内容を登録
            if (MembersipValidation::isError($post)){

                self::userEdit();
                return;
            }

            include($membersip_html_path.'user/view/page-user-edit-confirm.php');

        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }
    

    /**
     * ユーザー登録画面の表示
     * @return void
     */
    static private function userEdit($ERROR = array()):void {

        global $membersip_html_path;

        try{
            // ユーザー情報の再設定
            MembersipUserAuth::resetUser();

            include($membersip_html_path.'user/view/page-user-edit.php');

        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }


    /**
     * ユーザー登録完了画面
     * @return void
     */
    static public function userEditEnd():void {

        global $membersip_html_path;

        try{
            // 各情報を取得
            $user     = MembersipSession::getUser();
            $edit     = MembersipSession::getEdit();
            $userEdit = MembersipSession::getUserEdit();

            // ユーザー編集
            if(MembersipUserEditer::execute($user, $edit, $userEdit) == false){
                include($membersip_html_path.'user/view/page-user-edit.php');
                return;
            }

            // 完了画面を表示
            include($membersip_html_path.'user/view/page-user-edit-end.php');

        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }
}