<?php

class MembersipPluginPortal {

    function __construct() {}

    //=================================================
    // プラグインの説明画面
    //=================================================
    static public function showPage() {
        global $membersip_sql_path;
        global $membersip_html_path;

        include($membersip_html_path.'admin/view/page-portal.php');
    }
}