<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>归档</title>
    <script>location.href = '/#/archive'</script>
</head>
<body>
<div id="archive">
<?php foreach ($tree as $cate => $article) { ?>

    <h2 class="high">
        <a href="/category/<?= $cate ?>"><?= $cate ?></a>
    </h2>

    <?php foreach ($article as $v) { ?>

        <article>
            <a href="/article/<?= $v['id'] ?>"><?= $v['name'] ?></a>
            <time><?= date('Y-m-d', $v['ctime']) ?></time>
        </article>

    <?php } ?>

<?php } ?>
</div>
</body>
</html>
