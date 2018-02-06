<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title><?= $name ?></title>
    <script>location.href = '/#/category/<?= $name ?>'</script>
</head>
<body>
<div id="category">
    <h2 class="high">
        <a href="/category/<?= $name ?>"><?= $name ?></a>
    </h2>

    <?php foreach ($list as $v) { ?>

        <article>
            <a href="/article/<?= $v['id'] ?>"><?= $v['name'] ?></a>
            <time><?= date('Y-m-d', $v['ctime']) ?></time>
        </article>

    <?php } ?>
</div>
</body>
</html>
