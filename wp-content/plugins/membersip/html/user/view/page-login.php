
<?php 

// エラー表示
MembersipError::showError();
?>

<form method="post" action="<?php echo getCurrentURL(); ?>">
    <input type="hidden" name="type" value="login" />
    <div>
    ログインID：<input type="text" name="loginid" value="" />
    パスワード：<input type="text" name="password" value="" />
    </div>
    </br></br>
    <a href="/remember/">パスワード・ID忘れた場合</a></br>
    <a href="/regist/">ユーザー登録</a></br>
    <input type="submit" value="ログイン">
</form>
