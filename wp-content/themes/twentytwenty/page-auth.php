<?php
get_header(); 
?>

<?php 

// ログイン時は（引数なし＝トップへ）
MembersipUserAuth::loginLocation("/tournament/admin/");

// ログイン画面を表示
MembersipUserAuth::showPage();

?>