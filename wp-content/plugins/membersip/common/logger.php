<?php

class MembersipLogger {

    function __construct() {}

    /**
     * 情報ログ
     */
    static public function debugLog(...$value):void {

        if (DEBUG == true) {
            self::commonLog('debug', $value);
        }   
    }

    /**
     * 情報ログ
     */
    static public function infoLog(...$value):void {

        self::commonLog('info', $value);
    }

    /**
     * 警告ログ
     */
    static public function warnLog($exception, ...$value):void {

        $e = array();

        if (empty($exception) == false &&
            gettype($exception) == "object" && 
            get_class($exception) == "Exception") {

                $e['code']    = $exception->getCode();
                $e['file']    = $exception->getFile();
                $e['line']    = $exception->getLine();
                $e['message'] = $exception->getMessage();
        }

        self::commonLog('warn', $value);

        // 管理者へ通知
        $error['exception'] = $e;
        $error['server'] = $_SERVER;
        $error['get'] = $_GET;
        $error['post'] = $_POST;
        $error['sesssion'] = $_SESSION;
        self::errorMail($error);
        self::errorLine($error);

        // エラー画面の表示
        include($membersip_html_path.'user/view/page-error.php');
        exit (0);
    }

    /**
     * 異常ログ
     */
    static public function errorLog($exception, ...$value):void {

        global $membersip_html_path;

        $e = array();

        if (empty($exception) == false &&
            gettype($exception) == "object" && 
            get_class($exception) == "Exception") {

                $e['code']    = $exception->getCode();
                $e['file']    = $exception->getFile();
                $e['line']    = $exception->getLine();
                $e['message'] = $exception->getMessage();
        }

        $value["uid"] = $_SESSION['uid'];

        // エラーログの登録
        self::commonLog('error', $e, $value);

        // 管理者へ通知
        $error['exception'] = $e;
        $error['server'] = $_SERVER;
        $error['get'] = $_GET;
        $error['post'] = $_POST;
        $error['sesssion'] = $_SESSION;
        self::errorMail($error);
        self::errorLine($error);

        // エラー画面の表示
        include($membersip_html_path.'user/view/page-error.php');
    }

    /**
     * ログ登録共通処理
     */
    static private function commonLog($type, $value) {

        global $membersip_sql_path;

        $log = file_get_contents($membersip_sql_path.'ins_log.sql');
        $Database = new Database();

        $Database->insert($log, array(
            $type, 
            $_SESSION['uid'], 
            json_encode($_SERVER, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE), 
            json_encode($_SESSION, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
            json_encode($_POST, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
            json_encode($value, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
        ));
    }

    /**
     * エラーが発生した場合に管理者へ通知
     */
    static private function errorMail($message) {

        $from = "t-yamauchi@unhork.com";
        $to   = array(
            array("email" => "to-yamauchi@unhork.com"),
            array("email" => "t-yamauchi@unhork.jp")
        );
        $subject = "【異常】エラーが発生しています。";
        $body = "以下エラーが発生しています。確認してください\n\n".
            stripslashes(json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));

        MembersipMail::sendMail($from, $to, $subject, $body);
    }

    /**
     * ライン通知
     */
    static private function errorLine(...$message) {

        // トークンを記載します
        $to   = array("U6a588e74d746b320378a89f0a1b689a3");
        $body =  "以下エラーが発生しています。確認してください\n\n".
            stripslashes(json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));

        MembersipLine::sendLine($to ,$body);
    }
}