<?php

/**
* @package Login-Admin-plugin
*/
/*
Plugin Name: 会員認証管理プラグイン
Plugin URI: プラグインの公式サイトの案内用の自由なURL
Description: 会員認証管理プラグイン
Version: 1.0
Author: 山内　徹
Author URI: 作成者が所有するサイトの自由なURL
*/

define("DEBUG", true);

$membersip_root = dirname(__FILE__);
$membersip_sql_path    = $membersip_root.'/sql/';
$membersip_html_path   = $membersip_root.'/html/';
$membersip_common_path = $membersip_root.'/common/';
$themes_path = dirname(__FILE__).'/../../themes/'.get_template().'/';

//=================================================
// セッション開始
//=================================================
require_once $membersip_common_path.'session.php';

// ユニークIDが登録されていない場合は設定
if (MembersipSession::getSession("uid") == null) {
    MembersipSession::setSession('uid', uniqid());
}

//=================================================
// DB設定読み込み
//=================================================
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
require_once $membersip_common_path.'database.php';


//=================================================
// 共通処理読み込み
//=================================================
require_once $membersip_common_path.'logger.php';
require_once $membersip_common_path.'error.php';
require_once $membersip_common_path.'line.php';
require_once $membersip_common_path.'mail.php';
require_once $membersip_common_path.'validation.php';
require_once $membersip_common_path.'userRegister.php';
require_once $membersip_common_path.'userEditer.php';


//=================================================
// 管理画面の各ページの登録
//=================================================
require_once $membersip_html_path.'admin/exec/init.php';
require_once $membersip_html_path.'admin/model/pluginPortal.php';
require_once $membersip_html_path.'admin/model/pluginAdmin.php';
require_once $membersip_html_path.'admin/model/userAdmin.php';
require_once $membersip_html_path.'admin/index.php';


//=================================================
// テーマ画面の各ページの登録
//=================================================
require_once $membersip_html_path.'user/model/userAuth.php';
require_once $membersip_html_path.'user/model/userRegist.php';
require_once $membersip_html_path.'user/model/userEdit.php';
require_once $membersip_html_path.'user/model/userAuthRemember.php';


//=================================================
// テーマ側で利用するファンクション集
//=================================================
require_once $membersip_root.'/function.php';