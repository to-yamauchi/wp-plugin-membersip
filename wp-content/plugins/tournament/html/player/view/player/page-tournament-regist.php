<form method="post" action="<?php echo getCurrentURL();?>">
  <input type="hidden" name="type" value="user-regist" />
  <div>
    名前（姓）：<input type="text" name="sei" value="<?php echo regist()->sei;?>" />
    名前（名）：<input type="text" name="mei" value="<?php echo regist()->mei;?>" />
    電話番号：<input type="text" name="tel" value="<?php echo regist()->tel;?>" />
    メールアドレス：<input type="text" name="mail" value="<?php echo regist()->mail;?>" />
    性別：
    <div>
         <input type="radio" id="gender1" name="gender" value="男性" <?php echo (regist()->gender == "男性")?'checked':''; ?> >
         <label for="gender1">男性</label>
    </div>
    <div>
         <input type="radio" id="gender2" name="gender" value="女性" <?php echo (regist()->gender == "女性")?'checked':''; ?> >
         <label for="gender2">女性</label>
    </div>
  </div>
  <input type="submit" value="確認">
</form>