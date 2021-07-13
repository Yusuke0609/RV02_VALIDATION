<?php

require_once 'completed.php';

?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
</head>
<body>
<!-- *エラーがあれば表示 -->
<?php if (count($err) > 0) : ?>
    <?php foreach($err as $e) : ?>
        <p><?php echo $e ?></p>
    <?php endforeach ?>
<!-- エラーがなければ登録完了 -->
<?php else : ?>
    <p class="success">ユーザー登録が完了しました。</p>
<?php endif ?>
<!-- どちらでも戻るボタンは表示 -->
    <p class="success"><a href="./signup_form.php">戻る</a></p>

</body>
</html>