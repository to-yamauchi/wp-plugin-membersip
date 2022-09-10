<?php
get_header(); 

// ログイン時はトップへ
MembersipUserAuth::notLoginLocation("/auth/");

MembersipUserEdit::showPage();
?>

編集画面