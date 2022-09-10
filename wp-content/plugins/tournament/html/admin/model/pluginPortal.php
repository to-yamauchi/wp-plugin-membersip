<?php

class TournamentPluginPortal {

    function __construct() {}

    //=================================================
    // プラグインの説明画面
    //=================================================
    static public function showPage() {
        global $tournament_sql_path;
        global $tournament_html_path;

        include($tournament_html_path.'admin/view/page-portal.php');
    }
}