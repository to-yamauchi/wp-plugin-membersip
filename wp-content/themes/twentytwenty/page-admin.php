<?php
get_header(); 
?>

<!--
ここはトップページです。
-->
<?php
// 認証時および未認証時の遷移先指定
MembersipUserAuth::notLoginLocation("/auth/");
?>

管理ページ