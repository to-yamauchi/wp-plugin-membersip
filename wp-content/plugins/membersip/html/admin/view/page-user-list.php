<!DOCTYPE html>
<html lang="en">
  <head>
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
    <style>
        .jsgrid-row td, .jsgrid-alt-row td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            -webkit-text-overflow: ellipsis; /*Safari用*/
            -o-text-overflow: ellipsis; /*Opera用*/
        }
        #loader-bg {
          background-color: #fff;
          height: 100%;
          left: 0px;
          position: fixed;
          top: 0px;
          width: 100%;
          z-index: 100;
        }
        #loader-bg img {
          left: 50%;
          position: fixed;
          top: 50%;
          -webkit-transform: translate(-50%, -50%);
          -ms-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
          z-index: 100;
        }
        .test {
          background-color: #a9a9a9 !important;
        }
    </style>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
    <script>
      var user_list = <?php echo $user_list; ?>;
      var regist    = <?php echo $regist;    ?>;
    </script>
  </head>
  <body>

    <div>
        <h2>ユーザー登録一覧</h2>
    </div>

    <?php
      // エラー表示
      MembersipError::showError();
    ?>
    </br>

    <div id="jsGrid"></div>
    <script src="<?php echo membersip_content();?>admin/view/js/user_list.js"></script>
 
  </body>
</html>