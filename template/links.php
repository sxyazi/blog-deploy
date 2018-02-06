<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>链接</title>
    <script>location.href = '/#/links'</script>
</head>
<body>
<pre id="links">
# Links

<?php foreach ($config['links'] as $v) { ?>
<?= $v['title'] ?> [<?= $v['url'] ?>](<?= $v['url'] ?>)
<?php } ?>
</pre>
</body>
</html>
