<?php

/**
 * 認証設定管理画面のクラス
 */
class MembersipPluginAdmin {

    function __construct() {}

    /**
     * 認証設定管理画面
     */
    static public function showPage() {

        global $membersip_html_path;
        global $membersip_sql_path;
        global $post_json;
        global $server_json;
        global $themes_path;
        
        // POSTデータをJSON化
        $post_json   = json_decode(json_encode($_POST));
        $server_json = json_decode(json_encode($_SERVER));

        try {

            // 初期化実施パラメーター確認
            if ($post_json->type == "init") {

                // 初期化を実行
                MembersipInit::execute();
                return;
            }

            //　初期化実施確認
            if (MembersipInit::isInit() == false) {

                // 初期化未実施　初期化実施画面へ
                include($membersip_html_path.'admin/view/page-init.php');
                return;
            }

            // ユーザービュー一覧取得
            $viewContents = array();
            $dispContents = array();
            $userViews = glob($membersip_html_path."user/view/*.php");

            foreach($userViews as $key => $val) {
                $viewContents[basename($val)]['path'] = $val;
                $viewContents[basename($val)]['value'] = file_get_contents($val);
            }

            // ユーザー画面一覧取得
            $userDisps1 = glob($themes_path."index.php");
            $userDisps2 = glob($themes_path."page-*.php");
            $userDisps = array_merge($userDisps1, $userDisps2);

            foreach($userDisps as $key => $val) {
                $dispContents[basename($val)]['path'] = $val;
                $dispContents[basename($val)]['value'] = file_get_contents($val);
            }

            $viewContents = json_encode($viewContents, JSON_UNESCAPED_UNICODE);
            $dispContents = json_encode($dispContents, JSON_UNESCAPED_UNICODE);

            // 会員認証管理ページへ
            include($membersip_html_path.'admin/view/page-setting.php');

        } catch(Exception $e){
            // 各処理で実装しているため、特になし
        }
    }
}