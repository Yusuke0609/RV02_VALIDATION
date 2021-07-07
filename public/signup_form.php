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
      <form action="register.php" method="POST">
        <div class="form-group">
          <label for="username">名前</label>
          <input 
            type="text"
            name="username"
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
          <button type="submit">登録</button>
      </form>
    </div>
</body>

</html>