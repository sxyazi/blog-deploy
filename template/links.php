<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>链接</title>
</head>
<body>
<pre id="links">
# Friends

<?php foreach ($config['links'] as $v) { ?>
<?= $v['title'] ?> [<?= $v['url'] ?>](<?= $v['url'] ?>)
<?php } ?>
</pre>
</body>
</html>
