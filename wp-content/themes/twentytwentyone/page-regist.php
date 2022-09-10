<?php
get_header(); 
?>


<?php 

// ログイン時はトップへ
MembersipUserAuth::loginLocation();

// ユーザー登録画面を表示
MembersipUserRegist::showPage();
?>

ユーザー登録画面