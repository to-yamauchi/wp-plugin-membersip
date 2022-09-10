<?php

class MembersipUserAuth {

    function __construct() {}

    /**
     * ログイン or ログアウト　ボタンの切り替え
     * @param logout_redirect : ログアウト後の遷移先
     * @return void
     */
    static public function showBtn($logout_redirect = null){

        global $membersip_html_path;
        global $post;
        global $server_json;
        
        // POSTデータをJSON化
        $post        = json_decode(json_encode($_POST));
        $server_json = json_decode(json_encode($_SERVER));

        // 認証をしている場合
        if (self::isLogin() == true) {

            // ログアウト後の遷移先設定
            if ($logout_redirect == null) {
                $logout_redirect = "/";
            }

            // ログアウトボタンクリック
            if ($post->type == "logout") {
                self::doLogout($logout_redirect);
                return;
            }

            // ログアウトボタンの表示
            include($membersip_html_path.'user/view/btn-logout.php');
            return;
        }

        // ログインボタンの表示
        include($membersip_html_path.'user/view/btn-login.php');
    }


    /**
     * ログイン画面の切り替え
     * ログインをしていた場合は基のページへ遷移
     * @return void
     */
    static public function showPage(){

        global $post;
        global $server_json;
        global $membersip_html_path;
        
        // POSTデータをJSON化
        $post        = json_decode(json_encode($_POST));
        $server_json = json_decode(json_encode($_SERVER));

        // 入力チェック
        if (MembersipValidation::isError($post)){

            // もしエラーがある場合は、認証画面へ
            self::userAuth();
            return;
        }

        // ログイン処理（ログインをしていなくて、loginのパラメータが送信された場合）
        if ($post->type == "login") {
            if(self::doLogin() == false){
                include($membersip_html_path.'user/view/page-login.php');
            }
            return;
        }

        // それ以外は、認証画面へ
        self::userAuth();
        return;
    }

    /**
     * ユーザー登録画面の表示
     * @return void
     */
    static private function userAuth() {

        global $membersip_html_path;

        include($membersip_html_path.'user/view/page-login.php');
    }


    /**
     * ログイン状態をチェック
     * @return true: ログイン状態
     * @return false: ログアウト状態
     */
    static public function isLogin() {

        try{
            // ログイン済の場合
            if (isset(MembersipSession::getLogin()->userid)) {

                // ログインしている状態
                return true;
            }

            // ログインをしていない状態
            return false;    
        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        }    
    }

    
    /**
     * ログインの状態での遷移
     * @param $url :　ログイン時の遷移先(未指定時はトップ)
     */
    static public function loginLocation(
        $url = null // 認証している場合の遷移先
        ) {

        try {

            if (self::isLogin() == true){
                
                // 認証している場合
                if ($url == null || $url == "") {
                    $url = "/";
                }

                echo "<script>document.location = '".$url."';</script>";
                return;
            } 
            
            if (self::isLogin() == false && $url != null){
                MembersipSession::setSession('referer',  $url);
                return;
            }

        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }


    /**
     * ログインの状態での遷移
     * @param $url :　未ログイン時の遷移先(未指定時はトップ)
     */
    static public function notLoginLocation() {

        try {

            // ログインをしていない場合は、認証ページへ遷移
            if (self::isLogin() == false){

                // 認証ページへ遷移する前に現在のページを保存
                MembersipSession::setSession('referer', $_SERVER['REQUEST_URI']);
                echo "<script>document.location = '/auth/';</script>";
                return;
            }
        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }


    /**
     * ログイン処理を実施
     */
    static private function doLogin(string $loginid = null, string $password = null, $location = true, $relogin = false) {

        global $membersip_html_path;
        global $post;
        global $server_json;

        try {

            // POSTデータをJSON化
            $post        = json_decode(json_encode($_POST));
            $server_json = json_decode(json_encode($_SERVER));

            $loginid  = isset($post->loginid)?$post->loginid:$loginid;
            $password = isset($post->password)?$post->password:$password;

        

            if ($relogin == false) {

                // ユーザーID、パスワードの入力されていなかった場合は、同じログイン画面を表示
                if ($loginid == "" || $password == "") {
        
                    // ユーザー情報が存在しない（ログインエラー）
                    MembersipError::setError('ログインIDまたはパスワードが入力されていません。');
                    return false;
                }

                // ユーザー情報が存在するか確認
                $ret = self::getUserData($loginid, $password);
                if (count($ret) == 0 || $ret[0]->value == "") {

                    // ユーザー情報が存在しない（ログインエラー）
                    MembersipError::setError('ユーザーIDまたはパスワードが間違っています。');
                    return false;
                }
            }

            // ユーザー情報をセッションに登録
            if (isset($ret[0]->value)) {

                // ユーザー情報をセッションへ登録
                self::setUserData($ret);

                // ログインしているセッションIDをDBに登録
                $user = MembersipSession::getSession('user');
                $edit = MembersipSession::getSession('edit');
                $edit->session_id = session_id();
                $userEdit = MembersipSession::getSession('userEdit');
                MembersipUserEditer::execute($user, $edit, $userEdit);

                // ロケーション遷移が必要な場合は遷移
                if ($location) {

                    $referer = MembersipSession::getReferer();

                    if ($referer == null) {
                        $referer = "/";
                    }

                    // ログインしていた場合は、前のページに誘導
                   echo "<script>document.location = '".$referer."';</script>";
                }

                // ログイン処理のみの場合は、遷移させない
                return true;
            }

            return false;

            // どれにも該当無し
            throw new Exception('認証エラー：いずれにも該当無し');

        } catch(Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }

    /**
     * ユーザー情報を取得
     */
    static private function getUserData($loginid, $password) {

        global $membersip_sql_path;

        // DBにてユーザーが存在するかチェック
        try {
            $auth = file_get_contents($membersip_sql_path.'getUserAuth.sql');
            $Database = new Database();
            $Database->select($auth, array(
                $loginid, $password)
            );

            return $Database->getResult();

        } catch (Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }

    /**
     * ユーザー情報をセッションへ登録
     */
    static public function setUserData($userData) {

        $data = array();

        foreach(json_decode($userData[0]->value) as $key => $value) {

            if (is_array($value)) {
                if($key == "del_flg"){
                    $data = array_merge($data, array($key => (boolean)$value[0]->data));
                } else {
                    $data = array_merge($data, array($key => $value[0]->data));
                }
            } else {
                $data = array_merge($data, array($key => $value));
            }
        }

        // ユーザー情報をセッションに登録
        MembersipSession::setSession('login', json_decode($userData[0]->value));
        MembersipSession::setSession('user', json_decode($userData[0]->value));
        MembersipSession::setSession('edit', $data);
        MembersipSession::setSession('userEdit', json_decode($userData[0]->value));
    }


    /**
     * ログアウト処理を実施
     * @param redirect : ログアウト後の遷移先
     * @param location : 
     */
    static public function doLogout($redirect, $location = true) {

        global $membersip_html_path;
        global $post;
        global $server_json;
        
        // POSTデータをJSON化
        $post        = json_decode(json_encode($_POST));
        $server_json = json_decode(json_encode($_SERVER));

        // ログアウト処理（セッション削除）
        MembersipSession::clear();

        if ($location) {

            // ログアウト後の遷移先
            echo "<script>document.location = '".$redirect."';</script>";
        }
        
        return;
    }

    /**
     * ユーザー情報リセット
     */
    static public function resetUser(){

        $loginid  = MembersipSession::getUser()->loginid[0]->data;
        $password = MembersipSession::getUser()->password[0]->data;

        // ログアウト処理（セッション削除）
        MembersipSession::clear();

        // ユーザー情報取得
        $userData = self::getUserData(
            $loginid, $password
        );

        // ユーザー情報設定
        self::setUserData($userData);
    }
}