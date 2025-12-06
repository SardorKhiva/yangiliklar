<?php
/** @var object $pdo */

require_once __DIR__ . '/../db_helper.php';
require_once __DIR__ . '/header.php';

// id orqali kategoriya nomini olish
if (isset($_GET['id'])) {
    $id = (int)($_GET['id']) ?? 0;
    if ($id > 0) {
        $category_row = getCategoryById($id);
        $title = $category_row['title'];
    }
}

// id orqali kategoriya nomini yangilash
if (isset($_POST['cat_update']) && isset($_POST['title'])) {
    try {
        $title = trim($_POST['title']);
        updateCategory($id, $title);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

    <div class="container">
        <div class="row">
            <form method="post">
                <div class="mb-3">
                    <div class="mt-3 mb-3">
                        <label for="category_name_input"
                               class="form-label">Kategoriya nomi
                        </label>
                    </div>
                    <input type="text"
                           class="form-control"
                           id="category_name_input"
                           name="title"
                           value="<?= $category_row['title'] ?>"
                           autofocus>
                </div>
                <button type="submit"
                        name="cat_update"
                        class="btn btn-primary">Submit
                </button>
            </form>
        </div>
    </div>

<?php
require_once __DIR__ . '/footer.php';