<?php
$register = $_POST;

//検証結果がエラーであれば、エラーをエラー配列に入れる
$errors = [];

//検証方法: POSTで受け取ったデータを表示可能
//filter_input: usernameがPOSTで送られてきたら受け取れる
//user_name = signup_formで指定したname="user_name"
//否定も可能=user_nameが空だったらfalseを返す
if(!$data['user_name'] = filter_input(INPUT_POST, 'user_name')){
    $errors[] = "ユーザー名を記入してください";
}
if(!$data['email'] = filter_input(INPUT_POST, 'email')){
    $errors[] = "メールアドレスを記入してください";
}
//パスワードは特殊で正規表現を使用する
$data['password'] = filter_input(INPUT_POST, 'password');
//preg_matchはdefultはtrueなので!Falseで設定する
if (!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)) {
    $errors[] = "パスワードは英数字8文字以上100文字以下にしてください";
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
if ($password !== $password_conf) {
    $errors[] = "確認用パスワードが間違っています";
}

//上記の入力でエラーが0であれば
if (count($$errors) === 0) {
    //ユーザーを登録する処理
    //UserLogicクラスの中に静的なcreateUserを作成する
    //POSTでformから受け取った値をそのまま入れる
    //登録できているか$hasCreated変数に入れる(true or falseで返される)
    $hasCreated = UserLogic::createUser($_POST);
    //もしエラーがあればユーザー登録処理はスルーされ、下記*phpの処理に飛ぶ

    if(!$hasCreated) {
        $err[] = '登録に失敗しました';
    }
}

?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- *エラーがあれば表示 -->
<?php if (count($errors) > 0) : ?>
    <?php foreach($errors as $e) : ?>
        <p><?php echo $e ?></p>
    <?php endforeach ?>
<!-- エラーがなければ登録完了 -->
<?php else : ?>
    <p class="success">ユーザー登録が完了しました。</p>
<?php endif ?>
<!-- どちらでも戻るボタンは表示 -->
    <p class="success"><a href=".ref.code.php">戻る</a></p>

</body>
</html>