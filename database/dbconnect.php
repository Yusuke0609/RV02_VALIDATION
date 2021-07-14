<?php
//DBにコネクトするページ
require_once 'env.php';
//エラー内容表示
ini_set('display_errors', true);
function connect()
{
    //環境設定値
    $host = DB_HOST;
    $db   = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;

    //データベース情報(接続時の情報を入れる)
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            //エラーのモードを決める
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            //FETCH MODE => 配列をkeyとvalueで返す
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
        //エラーの中身を入れる
    } catch(PDOException $e) {
        echo "接続失敗です". $e->getMessage();
        exit();
    }
}