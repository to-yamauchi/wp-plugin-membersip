<?php
get_header(); 
?>

<!--
ここはトップページです。
-->
<?php
// 認証時ログインユーザー名を表示
echo username();

// 引数はログアウト時の遷移先（nullの場合はトップ）
// ログイン後は基のページへ遷移
MembersipUserAuth::showBtn();

// TournamentPlayerSelect::showPage();
?>

<?php
// ログインをしている場合は、リンクを表示
if (MembersipUserAuth::isLogin()){ 
?>
    <a href="/member">メンバーページへ</a>
<?php 
} 
?>
