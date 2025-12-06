<?php
/** @var object $pdo */

require_once __DIR__ . '/category_helper.php';
require_once __DIR__ . '/../header.php';

if (isset($_POST['cat_add']) && isset($_POST['title'])) {
    try {
        $title = trim($_POST['title']);
        addCategory($title);

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
                        <label for="category_name_input" class="form-label">Kategoriya nomi</label>
                    </div>
                    <input type="text" class="form-control" id="category_name_input" name="title" autofocus>
                </div>
                <button type="submit" name="cat_add" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

<?php
require_once __DIR__ . '/../footer.php';