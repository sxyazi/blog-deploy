<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>链接</title>
</head>
<body>
<div id="links">

# Friends

<?php foreach ($config['links'] as $v) { ?>
- <?= $v['title'] ?> [<?= $v['url'] ?>](<?= $v['url'] ?>)
<?php } ?>

</div>
</body>
</html>
