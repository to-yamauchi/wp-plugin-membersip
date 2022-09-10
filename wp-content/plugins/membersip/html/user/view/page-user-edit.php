


<div>
    <h4>ユーザー編集画面</h4>
</div>
<?php
  // エラー表示
  MembersipError::showError();
?>

<div style="width:50%;margin:0 auto;">
  <form method="post" action="<?php echo getCurrentURL();?>">
    <input type="hidden" name="type" value="user-edit" />
    <div>

      <div>名前（姓）</div>
      <div><input type="text" name="sei" value="<?php echo isset(edit()->sei)?edit()->sei:'' ?>" /></div>

      <div>名前（名）</div>
      <div><input type="text" name="mei" value="<?php echo isset(edit()->mei)?edit()->mei:'' ?>" /></div>

      <div>電話番号</div>
      <div><input type="text" name="tel" value="<?php echo isset(edit()->tel)?edit()->tel:'';?>" /></div>

      <div>メールアドレス</div>
      <div><input type="text" name="mail" value="<?php echo isset(edit()->mail)?edit()->mail:'';?>" /></div>

      <div>性別</div>
      <div>
          <input type="radio" id="gender1" name="gender" value="男性" <?php echo (((edit()->gender)?edit()->gender:'') == "男性")?'checked':''; ?>>
          <label for="gender1">男性</label>
      </div>
      <div>
          <input type="radio" id="gender2" name="gender" value="女性" <?php echo (((edit()->gender)?edit()->gender:'') == "女性")?'checked':''; ?>>
          <label for="gender2">女性</label>
      </div>

    </div>
    <input type="submit" value="確認">
  </form>
</div>