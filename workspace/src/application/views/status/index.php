<?php
/**
 * @var $this View.php
 **/
?>
<?= $this->setLayoutVar('title', 'ホーム') ?>

<h2>ホーム</h2>

<form action="<?= $base_url ?>/status/post" method="post">
    <input type="hidden" name="_token" value="<?= $this->escape($_token) ?>">
    <?php if (isset($errors) && count($errors) > 0): ?>
        <?= $this->render('errors', ['errors' => $errors]) ?>
    <?php endif; ?>
    <textarea name="body" cols="60" rows="2"><?= $this->escape($body) ?></textarea>
    <input type="submit" value="発言">
</form>
<div id="statuses">
    <?php foreach ($statuses as $status): ?>
        <?= $this->render('status/status', ['status' => $status]) ?>
    <?php endforeach; ?>
</div>
