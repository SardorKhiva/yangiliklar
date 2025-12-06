<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../db_helper.php';



if (isset($_GET['id'])) {
    $id = (int)($_GET['id']) ?? 0;
    $category_row = getCategoryById($id);
    $title = $category_row['title'];

    if ($_GET['confirm'] === 'yes') {
        deleteCategory($id);
    }
}
?>
    <div class="container">
        <label for="cat_del_no" class="mt-3 mb-3">Rostdan ham <strong> <?= $title ?></strong> kategoriyasini o'chirmoqchimisiz?
            <br>
            <a href="/admin/delete_category.php?id=<?= $id ?>&confirm=yes"
               id="cat_del_yes"
               class="btn btn-danger">Ha
            </a>
            <a href="/admin/category.php"
               id="cat_del_no"
               class="btn btn-primary">Yo'q
            </a>
        </label>
    </div>

<?php
require_once __DIR__ . '/footer.php';