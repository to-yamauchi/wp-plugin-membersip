<?php
get_header(); 

// ログイン時はトップへ
MembersipUserAuth::loginLocation();

// 未ログイン時はリメンバーページを表示
MembersipUserAuthRemember::showPage();
?>