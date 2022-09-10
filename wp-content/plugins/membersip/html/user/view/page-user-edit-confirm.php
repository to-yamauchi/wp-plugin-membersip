<form method="post" action="<?php echo getCurrentURL(); ?>">
    <input type="hidden" name="type" value="user-edit-confirm" />
  <div>
    名前（姓）： <? echo $post->sei; ?> </br>
    名前（名）： <? echo $post->mei; ?> </br>
    電話番号： <? echo $post->tel; ?> </br>
    メールアドレス： <? echo $post->mail; ?> </br>
    性別： <? echo $post->gender; ?> </br>
  </div>
  <input type="submit" name="trans" value="戻る">
  <input type="submit" name="trans" value="登録">
</form>