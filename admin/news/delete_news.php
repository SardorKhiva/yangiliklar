<?php
require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/news_helper.php';


if (isset($_GET['id'])) {
    $id = (int)($_GET['id']) ?? 0;
    $news_row = getNewsById($id);
    $title = $news_row['title'];

    if ($_GET['confirm'] === 'yes') {
        deleteNews($id);
    }
}
?>
    <div class="container">
        <label for="news_del_no" class="mt-3 mb-3">Rostdan ham <strong> <?= $title ?></strong> yangligini
            o'chirmoqchimisiz?
            <br>
            <a href="/admin/news/delete_news.php?id=<?= $id ?>&confirm=yes"
               id="news_del_yes"
               class="btn btn-danger">Ha
            </a>
            <a href="/admin/news/news.php"
               id="news_del_no"
               class="btn btn-primary">Yo'q
            </a>
        </label>
    </div>

<?php
require_once __DIR__ . '/../footer.php';