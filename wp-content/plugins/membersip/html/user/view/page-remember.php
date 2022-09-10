
<?php
// エラー表示
MembersipError::showError();

?>

<form method="post" action="<?php echo getCurrentURL(); ?>">
<input type="hidden" name="type" value="login" />
<div>
ユーザーID：<input type="text" name="userid" value="" />
パスワード：<input type="text" name="password" value="" />
</div>
<input type="submit" value="ログイン">
</form>
