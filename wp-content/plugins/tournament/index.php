<?php

/**
* @package Tounament-admin-plugin
*/
/*
Plugin Name: トーナメント管理プラグイン
Plugin URI: プラグインの公式サイトの案内用の自由なURL
Description: トーナメント管理プラグイン
Version: 1.0
Author: 山内　徹
Author URI: 作成者が所有するサイトの自由なURL
*/

$tournament_root = dirname(__FILE__);
$tournament_sql_path    = $tournament_root.'/sql/';
$tournament_html_path   = $tournament_root.'/html/';
$tournament_common_path = $tournament_root.'/common/';
$themes_path = dirname(__FILE__).'/../../themes/'.get_template().'/';


//=================================================
// 管理画面の各ページの登録
//=================================================
// require_once $tournament_html_path.'admin/exec/init.php';
require_once $tournament_html_path.'admin/model/pluginPortal.php';
// require_once $tournament_html_path.'admin/model/pluginAdmin.php';
// require_once $tournament_html_path.'admin/model/userAdmin.php';
require_once $tournament_html_path.'admin/index.php';
TournamentAdminIndex::init();


// //=================================================
// // テーマ画面の各ページの登録
// //=================================================
require_once $tournament_html_path.'player/model/playerSelect.php';
// require_once $tournament_html_path.'user/model/userRegist.php';
// require_once $tournament_html_path.'user/model/userEdit.php';
// require_once $tournament_html_path.'user/model/userAuthRemember.php';


//=================================================
// テーマ側で利用するファンクション集
//=================================================
require_once $tournament_root.'/function.php';