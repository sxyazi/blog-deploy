<h2 class="high">
    <a href="/category/<?= $name ?>"><?= $name ?></a>
</h2>

<?php foreach ($list as $v) { ?>

    <article>
        <a href="/article/<?= $v['id'] ?>.html"><?= $v['name'] ?></a>
        <time><?= date('Y-m-d', $v['ctime']) ?></time>
    </article>

<?php } ?>
