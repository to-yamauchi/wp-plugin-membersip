<?php
get_header();
?>


<!--
ここはメンバーページです。
-->
<?php

// 認証時および未認証時の遷移先指定
MembersipUserAuth::notLoginLocation("/auth/");

// ログイン時は、ログアウトボタンを表示
MembersipUserAuth::showBtn();

MembersipUserAuth::resetUser();

// ユーザー情報
echo "<pre>";
print_r(MembersipSession::getUser());
echo "</pre>";
?>

トーナメントの設定管理画面