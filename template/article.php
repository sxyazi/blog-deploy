<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title><?= $name ?></title>
    <script>location.href = '/#/article/<?= $id ?>'</script>
</head>
<body>
    <p>
        创建时间：<time><?= date('Y-m-d H:i:s', $ctime) ?></time>
    </p>
    <p>
        最后修改：<time><?= date('Y-m-d H:i:s', $mtime) ?></time>
    </p>

    <hr>
    <pre id="article"><?= htmlspecialchars($content) ?></pre>
</body>
</html>
