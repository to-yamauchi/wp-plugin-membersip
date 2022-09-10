<link rel="stylesheet" href="<?php echo membersip_content();?>admin/view/css/style.css">

<?php
if ($retIsInit == true) {
	return;
}
?>

<div class="wrap">
    <h2 id="test">会員認証管理</h2>

	<div class="not_init" style="margin:10px;">
		<strong>まだ初期化がされていません。初期化を行いますか？</strong>
	</div>

    <form method="post" action="<?php echo getCurrentURL();?>">
		<input type="hidden" name="type" value="init" />
		<input type="submit" value="Membersipの初期化を実施する">
	</form>
</div>