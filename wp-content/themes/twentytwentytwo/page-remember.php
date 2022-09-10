<?php
get_header(); 

// ログイン時はトップへ
MembersipUserAuth::loginLocation();

// 未ログイン時はリメンバーページを表示
MembersipUserAuthRemember::showPage();
?>

パスワード再発行画面