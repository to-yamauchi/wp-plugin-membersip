
<form method="post" action="<?php echo getCurrentURL();?>">
    <input type="hidden" name="type" value="user-regist-confirm" />
  <div>
    名前（姓）：<?php echo $post->sei; ?></br>
    名前（名）：<?php echo $post->mei; ?></br>
    電話番号：<?php echo $post->tel; ?></br>
    メールアドレス：<?php echo $post->mail; ?></br>
    性別：<?php echo $post->gender; ?></br>
  </div>
  <input type="submit" name="trans" value="戻る">
  <input type="submit" name="trans" value="登録">
</form>

