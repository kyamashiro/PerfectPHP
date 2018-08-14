<?php
try {
    //「PDO::ATTR_DEFAULT_FETCH_MODE」 データを取得する際の型を配列に指定
    //文字列以外のものは正しくキャストしてくれないので､エミュレーターをOFFにし､型キャストを行う
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    //charset utf-8のようにハイフンはいらない
    $pdo = new PDO('mysql:host=localhost;dbname=online_bbs;charset=utf8', 'root', 'password', $opt);
} catch (PDOException $e) {
    exit($e->getMessage());
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$results = $pdo->query($sql)->fetchAll();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = null;
    if (!isset($_POST['name']) || !strlen($_POST['name'])) {
        $errors['name'] = '名前を入力してください';
    } else if (strlen($_POST['name']) > 40) {
        $errors['name'] = '名前は40字以内で入力してください';
    } else {
        $name = $_POST['name'];
    }

    $comment = null;
    if (!isset($_POST['comment']) || !strlen($_POST['comment'])) {
        $errors['comment'] = 'ひとこと入力してください';
    } else if (strlen($_POST['comment']) > 200) {
        $errors['comment'] = 'ひとことは200文字以内で入力してください';
    } else {
        $comment = $_POST['comment'];
    }

    if (!count($errors)) {
        try {
            //"INSERT INTO posts (name, comment, created_at) VALUES(?, ?, NOW())";
            //疑問符付きプレースホルダも使える
            $sql = "INSERT INTO posts (name, comment, created_at) VALUES(:name, :comment, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue('name', (string)$name, PDO::PARAM_STR);
            $stmt->bindValue('comment', (string)$comment, PDO::PARAM_STR);
            $stmt->execute();

            header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}

include 'view/bbs_view.php';
?>