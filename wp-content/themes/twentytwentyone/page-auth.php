<?php
get_header(); 
?>

<?php 

// ログイン時はトップへ
MembersipUserAuth::loginLocation();

// ログイン画面を表示
MembersipUserAuth::showPage();
?>

認証画面