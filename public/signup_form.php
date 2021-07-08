<?php

//DBの設定値を入力

define('DB_HOST', 'localhost');
define('DB_NAME', 'workshop');
define('DB_USER', 'Yamauchi');
define('DB_PASS', 'yusuke0609');
define('DB_PORT', '3306');

//エラー内容表示
ini_set('display_errors', true);

// 出力する PHP エラーの種類を設定する
// https://www.php.net/manual/ja/function.error-reporting.php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// 文字化け対策
$option = array(PDO::MYSQL_ATTR_INIT_COMMAND =>"SET CHARACTER SET 'utf8mb4'");

// PHPのエラーを表示するように設定
error_reporting(E_ALL & ~E_NOTICE);

//環境設定値
$host = DB_HOST;
$db   = DB_NAME;
$user = DB_USER;
$pass = DB_PASS;

// データベースの接続
try {
  $dbh = new PDO('mysql:host=$host;dbname=$db', $user, $pass, $options);
  //オプション：エラーが発生したときに、PDOExceptionの例外を投る
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "接続失敗です". $e->getMessage();
  exit();
}

//検証結果がエラーであれば、エラーをエラー配列に入れる
$err = [];

/**
 * 実行結果を保持する。
 * 未完了: false
 * 完了: true
 */
$result = false;

// POSTデータは$data変数にいれる
$data = [];
$data['user_name'] = !empty($_POST['user_name'])? $_POST['user_name'] : '';
$data['email'] = !empty($_POST['email'])? $_POST['email'] : '';
$data['password'] = !empty($_POST['password'])? $_POST['password'] : '';

//検証方法: POSTで受け取ったデータを表示可能
//filter_input: usernameがPOSTで送られてきたら受け取れる
//username = signup_formで指定したname="username"
//否定も可能=usernameが空だったらfalseを返す
if(!$username = filter_input(INPUT_POST, 'username')){
  $err[] = "ユーザー名を記入してください";
}
if(!$username = filter_input(INPUT_POST, 'email')){
  $err[] = "メールアドレスを記入してください";
}
//パスワードは特殊で正規表現を使用する
$password = filter_input(INPUT_POST, 'password');
//preg_matchはdefultはtrueなので!Falseで設定する
if (!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)) {
  $err[] = "パスワードは英数字8文字以上100文字以下にしてください";
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
if ($password !== $password_conf) {
  $err[] = "確認用パスワードが間違っています";
}

//上記の入力でエラーが0であれば
if (count($err) === 0) {
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
$sql = 'INSERT INTO rv02_user (name, email, password) VALUE(?, ?, ?)';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $data['user_name'], PDO::PARAM_STR);
$stmt->bindParam(2, $data['email'], PDO::PARAM_STR);
$stmt->bindParam(3, password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
$stmt->execute();
$result = true;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー認証機能</title>
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <h1>ユーザー登録</h1>
    <div class="bg-example">
      <form action="signup_form.php" method="POST">
        <div class="form-group">
          <label for="username">名前</label>
          <input 
            type="text"
            name="user_name"
            id="exampleInputName"
            placeholder="名前"
            class="<?php echo !empty($errors['user_name'])? 'error': 'ok'?>" 
            value="<?php echo $data['user_name'] ?>"
          >
          <p class="error" style="color:red"><?php echo $errors['user_name']?></p>
        </div>
        <div class="form-group">
          <label for="Email">メールアドレス</label>
          <input 
            type="email" 
            name="email" 
            id="exampleInputEmail" 
            placeholder="メールアドレス" 
            class="<?php echo !empty($errors['email'])? 'error': 'ok'?>" 
            value="<?php echo $data['email'] ?>"
          >
          <p class="error" style="color:red"><?php echo $errors['email']?></p>
        </div>
        <div class="form-group">
          <label for="Password">パスワード</label>
          <input 
            type="password"
            name="password" 
            id="exampleInputPassword" 
            placeholder="パスワード"
            class="<?php echo !empty($errors['password'])? 'error': 'ok'?>" 
            value="<?php echo $data['password'] ?>"
          >
          <p class="error" style="color:red"><?php echo $errors['password']?></p>
        </div>
        <div class="form-group">
          <label for="Password_Conf">パスワード確認</label>
          <input 
            type="password"
            name="password_conf" 
            id="exampleInputPassword" 
            placeholder="確認用パスワードを入力してださい"
            class="<?php echo !empty($errors['password'])? 'error': 'ok'?>" 
            value="<?php echo $data['password'] ?>"
          >
          <p class="error" style="color:red"><?php echo $errors['password']?></p>
        </div>  
        <div class="button_position">
          <button type="submit">登録</button>
        </div>
      </form>
    </div>
</body>

</html>