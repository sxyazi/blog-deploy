<?php
    foreach ($list as $v) {
?>

<div>
    <p><?= $v['file'] ?></p>
    <p><?= $v['title'] ?></p>
    <p><?= $v['ctime'] ?></p>
    <p><?= $v['mtime'] ?></p>
</div>

<?
    }
?>