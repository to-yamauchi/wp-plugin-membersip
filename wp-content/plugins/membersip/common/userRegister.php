<?php
class MembersipUserRegister {

    function __construct() {
    }

        // ランダムな文字列を生成します (英字と数値)
    // $length: 生成する文字列の長さを指定します 
    static private function createRandomString($length) {

        global $membersip_sql_path;

        $result = "";
        $str = array_merge(range('a', 'z'), range('A', 'Z"'), range('0', '9'));

        while (true) {

            // ログインIDのランダム生成
            for ($i = 0; $i < $length; $i++) {
                $result .= $str[rand(0, count($str)-1)];
            }
    
            // 既存のログインIDの中で同一のものがあるか確認
            // あった場合は、利用できないため再度ランダムIDを作成
            $Database = new Database();
            $isLoginid = file_get_contents($membersip_sql_path.'isLoginId.sql');
            $Database->select($isLoginid, array($result));
            if ($Database->getResult()[0]->count == 0) {
                return $result;
            }
        }
    } 

    /**
     * 初期ログイン情報の作成
     */
    static private function createLogin():array {

        $userRegistData = array();

        $loginid  = strtoupper('LID'.self::createRandomString(10));
        $password = strtoupper(self::createRandomString(10));

        // ログインIDとパスワードを仮設定
        $userRegistData["loginid"]  = array(array("data" => $loginid  , "update" => date('Y-m-d H:i:s'), "remark" => "初期登録"));
        $userRegistData["password"] = array(array("data" => $password , "update" => date('Y-m-d H:i:s'), "remark" => "初期登録"));
        $userRegistData["plan"]     = array(array("data" => 1         ,array("from" => date('Ymd'),"to" => 299912), "update" => date('Y-m-d H:i:s'), "remark" => "初期登録"));
        $userRegistData["group"]    = array(array("data" => 1         ,array("from" => date('Ymd'),"to" => 299912), "update" => date('Y-m-d H:i:s'), "remark" => "初期登録"));
        $userRegistData["del_flg"]  = array(array("data" => false     ,array("from" => date('Ymd'),"to" => 299912), "update" => date('Y-m-d H:i:s'), "remark" => "初期登録"));

        return $userRegistData;
    }

    /**
     * ユーザー登録
     */
    static private function createUser($userRegistData) {

        global $membersip_sql_path;

        try {
            // 配列データをJSON形式に変換（文字列）
            $userData = (string)json_encode($userRegistData, JSON_UNESCAPED_UNICODE);

            $userRegistSql = file_get_contents($membersip_sql_path.'ins_user_regist.sql');
            $updUserIdSql = file_get_contents($membersip_sql_path.'upd_user_regist.sql');
            $Database = new Database();

            $Database->begin();
            
            // ユーザー登録
            $id = $Database->insert($userRegistSql, array($userData));

            // ユーザーID作成
            $userid = "U01".str_pad($id, 7, 0, STR_PAD_LEFT);

            // ユーザーIDの登録
            $Database->update($updUserIdSql, array($userid, $id));

            $Database->commit();

        } catch(Exception $e){
            MembersipLogger::errorLog($e);
            return false;
        }
    }

    /**
     * ユーザー登録形式に成型
     */
    static private function userRegistMolding($regist, $userRegistData){

        // 登録データのデータ移管
        foreach ($regist as $Key => $Value) {

            // 以下について入力値では登録をしない
            if (strcmp($Key, "type") == 0 || 
                strcmp($Key, "loginid") == 0 || 
                strcmp($Key, "password") == 0 ||
                strcmp($Key, "del_flg") == 0 ) {
                continue;
            }

            $userData = (object)[];
            $userData->data   = $Value;
            $userData->update = date('Y-m-d H:i:s');
            $userData->remark = "初回登録";

            $userRegistData = array_merge($userRegistData, array($Key => array($userData)));
        }

        return $userRegistData;
    }
    
    /**
     * ユーザー登録
     * @return void
     */
    static public function execute() {

        try {

            // 登録処理を行う前に、セッション情報を再度チェック
            $registSessionData = MembersipSession::getRegist();
            if (MembersipValidation::isError($registSessionData)){
                return false;
            }

            // ログイン情報の作成
            $loginData = self::createLogin();
        
            // ユーザー登録データの成型
            $userData = self::userRegistMolding($registSessionData, $loginData);
            
            // ユーザー登録
            self::createUser($userData);

            return true;

        } catch (Exception $e) {
            MembersipLogger::errorLog($e);
            return false;

        } finally {

            // 登録後は、セッション情報を削除
            MembersipSession::registClear();
        }
    }
}