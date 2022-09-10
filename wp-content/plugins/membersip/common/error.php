<?php

class MembersipError {

    function __construct() {
    }

    static public function setError(string $value = ''){

        $error = MembersipSession::getError();
        if ($error != null && is_array($error)) {
            $errors = $error;
        } else {
            $errors = array();
        }
        array_push($errors, $value);
        MembersipSession::setSession('error', $errors);
    }

    static public function setErrors(array $values = array()){
        MembersipSession::setSession('error', $values);
    }

    /**
     * エラー表示
     */
    static public function showError() {

        // 登録チェックエラーの表示
        $error = MembersipSession::getError();
        if ($error != null && is_array($error) && count($error) > 0) {
            echo '<div class="error" >'."\n";
            echo '<ul>'."\n";

            foreach($error as $key => $value){
                echo "<li>".$value."</li>"."\n";
            }
            
            echo '</ul>'."\n";
            echo '</div>'."\n";
        }

        // エラー表示後にエラー内容は削除
        MembersipSession::errorClear();
    }
}