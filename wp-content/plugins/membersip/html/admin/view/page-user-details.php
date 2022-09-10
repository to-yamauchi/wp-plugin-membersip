<!DOCTYPE html>
<html lang="en">
  <head>
    <style>
        form > div {
          display: flex;
          flex-flow: column;
        }
    </style>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script>
      var userData = JSON.parse('<?php echo $userData; ?>');

      $(function(){
        $('input[name=sei]').val(userData.sei[0].data);
        $('input[name=mei]').val(userData.mei[0].data);
        $('input[name=tel]').val(userData.tel[0].data);
        $('input[name=mail]').val(userData.mail[0].data);
        $('input[name=gender]').val([userData.gender[0].data]);
        $('select[name=pets]').val(['spider']);
      })
      
    </script>
  </head>
  <body>

    <div>
        <h2>ユーザー編集画面</h2>
    </div>
    <?php
      // エラー表示
      MembersipError::showError();
    ?>

    <div>
      <form method="post" action="<?php echo getCurrentURL();?>">
        <input type="hidden" name="type" value="user-edit" />
        <div>

          <div>名前（姓）</div>
          <div><input type="text" name="sei" value="" /></div>

          <div>名前（名）</div>
          <div><input type="text" name="mei" value="" /></div>

          <div>電話番号</div>
          <div><input type="text" name="tel" value="" /></div>

          <div>メールアドレス</div>
          <div><input type="text" name="mail" value="" /></div>

          <div>性別</div>
          <div>
              <input type="radio" id="gender1" name="gender" value="男性" >
              <label for="gender1">男性</label>
          </div>
          <div>
              <input type="radio" id="gender2" name="gender" value="女性" >
              <label for="gender2">女性</label>
          </div>

          <div>都道府県</div>
          <div>
            <select name="pets">
                <option value=""></option>
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
                <option value="hamster">Hamster</option>
                <option value="parrot">Parrot</option>
                <option value="spider">Spider</option>
                <option value="goldfish">Goldfish</option>
            </select>
          </div>

        </div>
        <input type="submit" value="確認">
      </form>
  </div>
  </body>
</html>