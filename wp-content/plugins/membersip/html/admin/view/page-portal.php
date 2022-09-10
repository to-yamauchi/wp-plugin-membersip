<link rel="stylesheet" href="<?php echo membersip_content();?>admin/view/css/style.css">

<div class="wrap">
    <h2 id="test">Membersipについて</h2>

    <div style="width:95%; height:100%;">

	  	<div>Membersipは、認証の仕組みを導入するためのプラグインとなります。</div>

          <div>以下のコードをfunctions.phpに記述する必要があります。</div>
          <pre>
<code>
function init_session_start(){
    session_save_path('C:\Users\t-yam\Local Sites\aaa\app\public\wp-content\plugins\membersip\session');
    session_set_cookie_params(0, '/', '.'.$_SERVER['HTTP_HOST'], true, true);
    session_start();
}
add_action('init', 'init_session_start');
</code>
          </pre>
		
    <div>
</div>