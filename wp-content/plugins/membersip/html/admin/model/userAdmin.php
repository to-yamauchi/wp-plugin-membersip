<?php

/**
 * 認証設定管理画面のクラス
 */
class MembersipUserAdmin {

    function __construct() {}

    /**
     * 認証設定管理画面
     */
    static public function showPage() {

        global $membersip_html_path;
        global $post;
        global $server_json;

        // POSTデータをJSON化
        $post   =  json_decode(json_encode($_POST, JSON_UNESCAPED_UNICODE));
        $get    =  json_decode(json_encode($_GET, JSON_UNESCAPED_UNICODE));
        $server_json = json_decode(json_encode($_SERVER, JSON_UNESCAPED_UNICODE));


        $user_list = "{}";

        // ユーザー登録
        $regist = "{}";
        if ($post->type == "user-regist") {

            $regist = json_encode($post, JSON_UNESCAPED_UNICODE);

            // ユーザー登録
            self::executeRegister();
        }

        // ユーザー詳細
        if ($get->type == "user-details") {
            self::userDetails($get->userid);
            return;
            // self::executeEdit();
        }

        // ユーザー編集
        if ($post->type == "user-edit") {
            self::executeEdit();
            return;
        }

        // ユーザー検索
        $search = "{}";
        if ($post->type == "user-search") {

            $search = json_encode($post, JSON_UNESCAPED_UNICODE);

            // ユーザー一覧を取得
            $user_list = self::userList();
        }

        include($membersip_html_path.'admin/view/page-user-list.php');
    }

    /**
     * ユーザー編集
     */
    static private function executeRegister():void {

        $post   =  json_decode(json_encode($_POST, JSON_UNESCAPED_UNICODE));

        MembersipSession::setSession('regist', $post);
        MembersipUserRegister::execute();
    }


    /**
     * ユーザー編集
     */
    static private function executeEdit():void {

        global $post;

        $membersipEdit = new MembersipUserEditer();

        // 編集に必要なデータを取得
        $user = $membersipEdit->getUserData($post->userid);

        // 各セッションへ設定
        MembersipSession::setSession('user', $user);
        MembersipSession::setSession('edit', $post);
        MembersipSession::setSession('userEdit', $user);

        // 編集実行
        $membersipEdit->execute(
            MembersipSession::getUser(), 
            MembersipSession::getEdit(), 
            MembersipSession::getUserEdit()
        );
    }

    /**
     * ユーザー詳細画面（編集）
     */
    static private function userDetails($userid) {

        global $membersip_html_path;
        global $membersip_sql_path;
        global $wpdb;

        // ユーザー情報を取得
        $Database = new Database();
        $getUser = file_get_contents($membersip_sql_path.'getUser.sql');
        $sql = $wpdb->prepare($getUser, $userid);
        $Database->getSelect($sql);
        $userData = $Database->getResult()[0]->value;

        include($membersip_html_path.'admin/view/page-user-details.php');
    }

    /**
     * ユーザー登録画面の表示
     * @return void
     */
    static private function userList() {

        global $membersip_html_path;
        global $membersip_sql_path;
        global $post;
        global $wpdb;

        // DBにてユーザーが存在するかチェック
        try {

            $Database = new Database();

            // ユーザー登録フォームより確認へ
            if ($post->type == "user-search") {

                if ($post->plan == "") {
                    $post->plan = 1;
                }

                if ($post->group == "") {
                    $post->group = 1;
                }

                $del_flg1 = 0;
                $del_flg2 = 1;
                if ($post->del_flg != "undefined" && $post->del_flg=="true"){
                    // true
                    $del_flg1 = 1;
                }

                if ($post->del_flg != "undefined" && $post->del_flg=="false") {
                    // false
                    $del_flg2 = 0;
                }

                unset($post->type);
                $userList = file_get_contents($membersip_sql_path.'getUserListFilter.sql');
                $sql = $wpdb->prepare($userList,
                    $del_flg1,
                    $del_flg2,
                    "%".$wpdb->esc_like($post->userid)."%",
                    "%".$wpdb->esc_like($post->loginid)."%",
                    "%".$wpdb->esc_like($post->password)."%",
                    "%".$wpdb->esc_like($post->sei)."%",
                    "%".$wpdb->esc_like($post->mei)."%",
                    "%".$wpdb->esc_like($post->tel)."%",
                    "%".$wpdb->esc_like($post->mail)."%",
                    "%".$wpdb->esc_like($post->gender)."%"
                );
                $Database->getSelect($sql);
            } else {
                
                $userList = file_get_contents($membersip_sql_path.'getUserList.sql');
                $Database->select($userList);
            }

            $users = $Database->getResult();
            return json_encode($users, JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }
}