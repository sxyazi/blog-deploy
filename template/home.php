<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
</head>
<body>
<div id="home">
    <?php foreach ($list as $v) { ?>

        <article>
            <a href="/article/<?= $v['id'] ?>.html"><?= $v['name'] ?></a>
            <time><?= date('Y-m-d', $v['ctime']) ?></time>
        </article>

    <?php } ?>
</div>
</body>
</html>
