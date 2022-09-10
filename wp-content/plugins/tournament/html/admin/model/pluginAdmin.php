<?php

/**
 * 認証設定管理画面のクラス
 */
class TournamentPluginAdmin {

    function __construct() {}

    /**
     * 認証設定管理画面
     */
    static public function showPage() {

        global $tournament_html_path;
        global $tournament_sql_path;
        global $post_json;
        global $server_json;
        global $themes_path;
        
        // POSTデータをJSON化
        $post_json   = json_decode(json_encode($_POST));
        $server_json = json_decode(json_encode($_SERVER));

        try {


            // 会員認証管理ページへ
            include($tournament_html_path.'admin/view/page-setting.php');

        } catch(Exception $e){
            // 各処理で実装しているため、特になし
        }
    }
}