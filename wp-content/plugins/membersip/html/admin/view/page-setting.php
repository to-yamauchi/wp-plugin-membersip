
<link rel="stylesheet" href="<?php echo membersip_content();?>admin/view/css/style.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.8.1/ace.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.8.1/mode-php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.8.1/theme-monokai.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.8.1/ext-language_tools.min.js"></script>
<script>
	var viewContents = <?php echo $viewContents; ?>;
    var dispContents = <?php echo $dispContents; ?>;
</script>
<div class="wrap">
    <h2 id="test">認証設定管理</h2>

    <div style="width:95%; height:100%;">

		<div id="tab_content" style="display: flex;justify-content: space-between;flex: 1 3;">
			<div style="width:20%;height:500px;background-color:#f00;display: flex;flex-direction:column;">
				<div style="width:100%;height:50px;background-color:#ff0;">テスト</div>
				<div>
					<ul>
						<li>test1</li>
						<li>test2</li>
					</ul>
				</div>
				<div style="width:100%;height:50px;background-color:#ff0;">テスト</div>
			</div>
			<div id="editor" style="width:100%;height: 600px"></div>
		</div>
    <div>
</div>

<script>
	console.log(viewContents);
	console.log(dispContents);

	var editor = ace.edit("editor");
	editor.setTheme("ace/theme/monokai");
	editor.resize();
	editor.$blockScrolling = Infinity;
	editor.session.setMode("ace/mode/php");
	editor.setFontSize('16px');
	editor.setOptions({
		enableBasicAutocompletion: true,
		enableSnippets: true,
		enableLiveAutocompletion: true
	});
	editor.setValue(dispContents['index.php'].value, -1);
</script>



