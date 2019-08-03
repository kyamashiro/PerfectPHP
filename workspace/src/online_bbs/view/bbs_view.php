<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ひとこと掲示板</title>
</head>
<body>
<h1>ひとこと掲示板</h1>
<form action="bbs.php" method="post">
    <?php if (count($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <li>
                <?= $error ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
    <label for="name">名前:<input type="text" name="name"></label><br>
    <label for="comment">ひとこと:<input type="text" name="comment" size="60"></label><br>
    <input type="submit" value="送信">
</form>
<?php
if ($results) {
    foreach ($results as $result) {
        print_r("<ul>
    <li>
    name:{$result['name']} comment:{$result['comment']} 投稿日時:{$result['created_at']}
    </li>
</ul>");
    }
}
?>

</body>
</html>