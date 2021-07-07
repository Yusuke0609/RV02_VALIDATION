<?php

//DBへの登録が必要
require_once '../dbconnect.php';

//クラス定義
//cretaeUserメソッド
Class UserLogic
{
    /**
     * ユーザーを登録する
     * @param array $userData
     * @return bool $result
     */

    //静的に設定する必要がある
    //staticの理由：registre.phpのUserLogic::createUserで::でクラスのメソッドを呼び出しているから
    public static function createUser($userData)
    {
        $result = false;

        //プレースホルダー
        //?,?,?には配列で値を入れる
        //UserDataを受け取って配列に入れる
        $sql = 'INSERT INTO users (name, email, 
        password) VALUE(?, ?, ?)';

        //UserDataを配列に入れる
        $arr = [];
        $arr[] = $userData['username'];//name(VALUESの一つ目の?)
        $arr[] = $userData['email'];//email
        //パスワードの値はハッシュ化する必要がある: 第二引数が必要
        $arr[] = password_hash($userData['password'],PASSWORD_DEFAULT);//password
        
        
        //DB処理を行う場合、例外処理を行う
        try {
            //上記SQL文の実行を行う
            //DBにコネクトする
            //prepareを使ったら、stmt変数を使用する
            $stmt = connect()->prepare($sql);
            //excecuteの結果を$resultへ入れる = 成功であればtrueを返す
            $result = $stmt->execute($arr);
            return $result;
        } catch(\Exception $e) {
            //例外が発生した場合、falseを返す->最初にfalseを定義する
            return $result;

        }
    }
}
?>