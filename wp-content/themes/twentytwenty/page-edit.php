<?php
get_header(); 

// ログイン時はトップへ
MembersipUserAuth::notLoginLocation("/auth/");

MembersipUserEdit::showPage();
?>