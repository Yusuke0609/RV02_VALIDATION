<?php

//DBの設定値を入力
define('DB_HOST', 'localhost');
define('DB_NAME', 'workshop');
define('DB_USER', 'Yamauchi');
define('DB_PASS', 'yusuke0609');
define('DB_PORT', '3306');

// エラー情報を表示する
// https://www.php.net/manual/ja/errorfunc.configuration.php#ini.error-reporting
ini_set('display_errors', "On");

// 出力する PHP エラーの種類を設定する
// https://www.php.net/manual/ja/function.error-reporting.php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// 文字化け対策
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'");

// PHPのエラーを表示するように設定
error_reporting(E_ALL & ~E_NOTICE);

//環境設定値
//$host = DB_HOST;
//$db   = DB_NAME;
//$user = DB_USER;
//$pass = DB_PASS;

// データベースの接続
//$dsn変数へ格納する
//$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $dbh = new PDO('mysql:host=localhost;port=3306;dbname=workshop', 'Yamauchi', 'yusuke0609', $options);
    //エラーのモードを決める
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //例外の場合の処理 "$e"
} catch(PDOException $e) {
    //例外時のメッセージ
    echo "接続失敗です". $e->getMessage();
    exit();
}

// エラーを格納する変数
$errors = [];

/**
 * 実行結果を保持する。
 * 未完了: false
 * 完了: true
 */
//登録が完了していない場合はフォームを表示する仕様
$result = false;

// POSTデータは$data配列にいれる
$data = [];
//三項演算子：
//user_name入力値が空でなければ、値を$data配列に代入する。
//user_nameが入力されていなければ空('')を$data配列に代入する
$data['user_name'] = !empty($_POST['user_name'])? $_POST['user_name'] : '';
$data['email'] = !empty($_POST['email'])? $_POST['email'] : '';
$data['password'] = !empty($_POST['password'])? $_POST['password'] : '';

//POSTリクエストの場合はバリデーションを実行する
//$_POSTが空ではない、かつ、$_POST['user_name']が空の場合=user_nameのフォームに何も入力せずに送信した場合、errors配列に'user_name'を代入する
if (!empty($_POST)) {
  if (empty($_POST['user_name'])) {
    $errors['user_name'] = '名前を入力してください。';
  }
  if (empty($_POST['email'])) {
    $errors['email'] = 'メールアドレスを入力してください。';
  }
  if (empty($_POST['password'])) {
    $errors['password'] = 'パスワードを入力してください。';
  }
    //もしエラーでなければ
  if (empty($errors)) {

    //プレースホルダー
    //?,?,?には配列で値を入れる
    //UserDataを受け取って配列に入れる
    //INSERT 文: INSERT INTO tbl_name (col_name1, col_name2, ...) VALUES (value1, value2, ...)
    $stmt = $dbh->prepare ('INSERT INTO rv02_user (user_name, email, password) VALUE(?, ?, ?)');
    //PDO::PARAM_STR は"文字列"という意味
    $stmt->bindParam(1, $data['user_name'], PDO::PARAM_STR);
    $stmt->bindParam(2, $data['email'], PDO::PARAM_STR);
    //ハッシュは文字列を解読しづらくする難読化
    $stmt->bindParam(3, password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmt->execute();
    $result = true;
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー認証機能</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>ユーザー登録</h1>
<!-- もし$resultがempty=trueであれば、下記処理をする -->
  <?php if($result): ?>
    <p class="success">処理が完了しました。</p>
  <?php else: ?>

    <div class="bg-example">
      <form action="./index.php" method="post">
        <div class="form-group">
          <label for="exampleInputName">名前</label>
<!-- 125行目：$errorsのuser_nameが空でなければ errorが表示されます。 -->
<!-- 125行目：$errorsのuser_nameが空であれば okが表示されます。 -->
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
          <label for="exampleInputEmail">メールアドレス</label>
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
          <label for="exampleInputPassword">パスワード</label>
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
 
  <?php endif ?>
</body>

</html>