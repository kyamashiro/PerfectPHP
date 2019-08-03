<?php
/**
 * @var $this View.php
 **/
?>
<?= $this->setLayoutVar('title', 'アカウント登録') ?>

<h1>アカウント登録</h1>

<form action="<?= $base_url ?>/account/register" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token) ?>">
    <?php if (isset($errors) && count($errors) > 0): ?>
        <?= $this->render('errors', ['errors' => $errors]) ?>
    <?php endif; ?>
    <table>
        <tbody>
        <tr>
            <th>ユーザID</th>
            <td><input type="text" name="user_name" value="<?= $this->escape($user_name) ?>"></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td><input type="password" name="password" value="<?= $this->escape($password) ?>"></td>
        </tr>
        </tbody>
    </table>
    <input type="submit" value="登録">
</form>