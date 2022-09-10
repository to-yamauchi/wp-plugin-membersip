<?php

class TournamentPlayerSelect {

    function __construct() {}

    /**
     * ログイン画面の切り替え
     * ログインをしていた場合は基のページへ遷移
     * @return void
     */
    static public function showPage(){

        global $post;
        global $get;
        global $server_json;
        
        // POSTデータをJSON化
        $get         = json_decode(json_encode($_GET));
        $server_json = json_decode(json_encode($_SERVER));

        // ログイン処理（ログインをしていなくて、loginのパラメータが送信された場合）
        if ($get->token != "") {
            self::ShowPlayer($get->token);
            return;
        }

        // それ以外は、認証画面へ
        self::ShowError();
        return;
    }


    /**
     * エラー画面（トークン未指定、誤ったトークン）
     */
    static private function ShowError() {

        global $tournament_html_path;

        include($tournament_html_path.'player/view/error/error.php');
    }

    /**
     * ユーザー情報を取得
     */
    static private function ShowPlayer(string $token) {

        global $tournament_html_path;

        // DBにてトークンに紐づく情報を取得

        if ($token == "1") {
            include($tournament_html_path.'player/view/player/page-player-select-1.php');
        }

        if ($token == "2") {
            include($tournament_html_path.'player/view/player/page-player-select-2.php');
        }
    }
}