<?php

class MembersipSession {

    function __construct() {
    }

    static public function setSession($name, $value) {
        unset($_SESSION["membersip_".$name]);
        $_SESSION["membersip_".$name] = $value;
    }

    static public function getSession($name) {
        return json_decode(json_encode($_SESSION["membersip_".$name]));
    }

    static public function clear() {
        $uid = $_SESSION['"membersip_"uid'];
        
        session_unset();
        $_SESSION = array();

        $_SESSION['"membersip_"uid'] = $uid;
    }

    static public function destroy($id) {
        foreach ( glob(session_save_path().'/*'.$id) as $file ) {
            unlink($file);
        }
    }

    static public function registClear() {
        $_SESSION["membersip_regist"] = array();
        unset($_SESSION["membersip_regist"]);
    }

    static public function errorClear() {
        $_SESSION["membersip_error"] = array();
        unset($_SESSION["membersip_error"]);
    }

    static public function getLogin() {
        return self::getSession('login');
    }

    static public function getUser() {
        return self::getSession('user');
    }

    static public function getEdit() {
        return self::getSession('edit');
    }

    static public function getUserEdit() {
        return self::getSession('userEdit');
    }

    static public function getRegist() {
        return self::getSession('regist');
    }

    static public function getError() {
        return self::getSession('error');
    }

    static public function getReferer() {
        return self::getSession('referer');
    }
}