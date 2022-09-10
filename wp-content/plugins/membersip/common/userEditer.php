<?php
class MembersipUserEditer {

    public function __construct(){
    }

    /**
     * ユーザー情報を取得
     */
    static public function getUserData($userid) {

        global $membersip_sql_path;

        // DBにてユーザーが存在するかチェック
        try {
            $auth = file_get_contents($membersip_sql_path.'getUser.sql');
            $Database = new Database();
            $Database->select($auth, array($userid));
            $user = $Database->getResult();

            return json_decode($user[0]->value);

        } catch (Exception $e) {
            MembersipLogger::errorLog($e);
        }
    }

    static public function setSessionId() {
        
        global $membersip_sql_path;

        // データ登録
        $updUserSessionId = file_get_contents($membersip_sql_path.'upd_user_session_id.sql');
        $Database = new Database();

        try {

            $Database->begin();
            
            // セッションIDを登録
            $Database->update($updUserSessionId, array(session_id(), MembersipSession::getUser()->userid));

            $Database->commit();

            return true;

        } catch(Exception $e) {

            $Database->rollback();

            // もし登録でサーバーエラーが発生した場合は
            MembersipLogger::errorLog($e);

            return false;
        }
    }

    /**
     * ユーザー編集
     * @param $user 
     * @param $edit
     * @param $userEdit
     * @return void
     */
    static public function execute(
        $user, $edit, $userEdit) {

        global $membersip_sql_path;

        try {

            // 登録処理を行う前に、セッション情報を再度チェック
            if (MembersipValidation::isError($edit)){
                return false;
            }

            // 登録データのデータ移管
            foreach ($edit as $editKey => $editValue) {

                if ($editKey === "session_id") {
                    $userEdit->session_id = $edit->session_id;
                    continue;
                }
                
                // ユーザー情報の中にないキーが指定された場合は、スキップ
                if (!array_key_exists($editKey, $user)) {
                    continue;
                }

                // 歴情報ではない場合
                if (is_array($user->$editKey) == false) {
                    $userEdit->$editKey = $edit->$editKey;
                    continue;
                }

                // 歴情報の場合
                if (is_array($user->$editKey) == true) {

                    // 変更のあるものだけを設定(基の情報と一致確認：不一致＝変更有)
                    if ((string)$user->$editKey[0]->data != $edit->$editKey) {

                        $userData = (object)[];
                        $userData->data   = $editValue;
                        $userData->update = date('Y-m-d H:i:s');
                        $userData->remark = "編集画面にて更新";
    
                        // 削除情報は、trueの場合に変更完了後、強制ログアウト
                        if ($editKey == "del_flg") {
                            $del = ($editValue === 'true');
                            $userData->data = $del;
                        }
    
                        array_unshift($userEdit->$editKey, $userData);
                    }
                }
            }

            // データ登録
            $updUserEdit = file_get_contents($membersip_sql_path.'upd_user_edit.sql');
            $Database = new Database();

            try {

                // ユーザー登録
                $Database->begin();
                $userData = (string)json_encode($userEdit, JSON_UNESCAPED_UNICODE);
                $Database->update($updUserEdit, array($userData, MembersipSession::getUser()->userid));
                $Database->commit();

                // 削除フラグ：True -> セッションファイルの削除（強制ログアウト）
                if ($del === true && $userEdit->session_id != null) {
                    MembersipSession::destroy($userEdit->session_id);
                }

                return true;

            } catch(Exception $e) {

                $Database->rollback();

                // もし登録でサーバーエラーが発生した場合は
                MembersipLogger::errorLog($e);

                return false;
            }

        } catch (Exception $e) {

            MembersipLogger::errorLog($e);
        }
    }
}