<div id="setting-error-invalid_siteurl" class="notice notice-error settings-error"> 
    <p>

<!-- E00001 -->
<?php if ($message_id == "E00001") { ?>
    <strong>初期化チェックでエラーが発生しました。</strong>
    <pre>
        <?php echo $e; ?>
    </pre>
<?php } ?>

<!-- E00002 -->
<?php if ($message_id == "E00002") { ?>
    <strong>初期化でエラーが発生しました。</strong>
    <pre>
        <?php echo $e; ?>
    </pre>
<?php } ?>

    </p>
</div>