<?php
/** @var object $pdo */

require_once __DIR__ . '/news_helper.php';
require_once __DIR__ . '/../category/category_helper.php';
require_once __DIR__ . '/../authors/users_helper.php';
require_once __DIR__ . '/../header.php';

$upload_dir = __DIR__ . "/../../uploads/news_img/";  // rasmlar yuklanadigan joy


if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// id orqali yangilik nomini olish
if (isset($_GET['id']) || isset($_POST['id'])) {
    $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
    if ($id > 0) {
        $category_name = getCategoryById($id);
        $category_name = $category_name['title'];
        $news_row = getNewsById($id); // shu id dagi yangilik massivi
        $news_content = $news_row['content'];  // shu id dagi yangilik matni
        $title = $news_row['title'];  // tahrirlanayotgan yangilik sarlavhasi
        $news_category_id = $news_row['category_id'];  // tahrirlanayotgan yangilik kategoriya id si
        $authors = getAuthorsList();  // barcha yangilik mualliflari
        $current_author_id = $authors[0]['id']; // tahrirlanayotgan yangilik muallifi id si
        $current_user_array = getAuthorById($current_author_id); //
        $current_author_name = $current_user_array['username'];
    }
}

// id orqali yangilik yangilash
if (isset($_POST['news_update'])) {
    try {
        $title = trim($_POST['title']);
        $content = trim($_POST['news_content']);
        $category_id = trim($_POST['category_id']);
        $author_id = trim($_POST['author_id']);
        $new_image_name = $_FILES['image']['name']; // yangi rasm nomi
        $old_image_name = $_POST['old_image_name'];  // yashirin maydondan eski rasm nomini olish
        // yangi nom bo'sh bo'lsa eski nom, aks holda yangi rasm nomi ishlatilsin
        if (empty($new_image_name)) {
            $image = $old_image_name;
        } else {
            $image = $new_image_name;
            if (move_uploaded_file($_FILES['image']['tmp_name'], ($upload_dir . $image))) {
                echo 'move_uploaded_file';
            }
        }
        updateNews($id, $title, $content, $category_id, $author_id, $image);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// TODO: category id ni olish kerak, joriy kategoriyani ko'rsatish uchun
/*
echo "<br>";
echo "<pre>";
print_r($news_category_id);
echo "</pre>";
*/
?>

    <div class="container">
        <h2>Yangilikni tahrirlash</h2>
        <div class="row">
            <form method="post" enctype="multipart/form-data">
                <!-- Tahrirlash qismi -->
                <div class="mb-3">

                    <!-- Tahrirlanayotgan yangilik id si -->
                    <div class="mb-3 form-control bg-danger-subtle">
                        <label class="form-label">ID: </label>
                        <?= $id; ?>
                        <input type="hidden" name="id" value="<?= $id ?? 0 ?>">
                    </div>

                    <!-- Yangilik sarlavhasini tahrirlash -->
                    <div class="mt-3">
                        <label for="news_title"
                               class="form-label">Sarlavha
                        </label>
                        <input type="text"
                               class="form-control"
                               id="news_title"
                               placeholder="Sarlavhani kiriting"
                               name="title"
                               value="<?= $title ?? '' ?>"
                               autofocus>
                    </div>

                    <!--     Yangilik kategoriyasini tahrirlash               -->
                    <div class="mt-3">
                        <label for="category_name_select"
                               class="form-label mt-3">
                            Kategoriya
                            <?php $current_category_name = $news_row['title'] ?>
                        </label>
                        <select id="category_name_select"
                                name="category_id"
                                class="form-select">

                            <?php foreach (allCategory() as $category): ?>
                                <option value="<?= $category['id']; ?>"
                                        <?= $category['id'] == $news_category_id ? 'selected' : '' ?>>
                                    <?= $category['title']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Yangilik muallifini tahrirlash -->
                    <div class="mt-3">
                        <label for="author"
                               class="form-label">
                            Muallif
                            <?php $current_news_author_id = $news_row['author_id']; ?>
                            <select class="form-select" name="author_id">
                                <?php foreach ($authors as $author): ?>
                                    <option value="<?= $author['id'] ?>"
                                            <?= ($author['id'] == $current_news_author_id) ? 'selected' : '' ?>>
                                        <?= $author['username'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>

                    <!-- Yangilik mazmunini tahrirlash -->
                    <div class="mt-3">
                        <label for="news_content"
                               class="form-label">
                            Yangilik mazmuni
                        </label>
                        <textarea
                                class="form-control"
                                autofocus
                                id="news_content"
                                name="news_content"
                                rows="10"><?= htmlspecialchars($news_content) ?>&nbsp
                        </textarea>
                    </div>

                    <!-- Yangilik rasmini tahrirlash -->
                    <div class="mt-3">
                        <label for="image">
                            Hozirgi rasm
                        </label>

                        <?php if (!empty($news_row['image'])):
                            $image_web_path = '/uploads/news_img/' . $news_row['image'];
                            ?>
                            <div class="mb-2">
                                <img src="<?= $image_web_path ?>"
                                     alt="Current news image"
                                     style="max-width: 200px;
                                     height: auto;">
                                <p class="text-muted small">
                                    Fayl nomi: <?= $news_row['image'] ?>
                                </p>
                            </div>

                            <input type="hidden"
                                   name="old_image_name"
                                   value="<?= $news_row['image'] ?>">
                        <?php endif; ?>

                        <label for="image" class="mt-2">
                            Yangi rasm tanlash
                        </label>
                        <input type="file"
                               name="image"
                               value="<?= $news_row['image'] ?>"
                               accept="image/jpeg, image/png, image/webp"
                               class="form-control">
                    </div>

                </div>

                <!-- Kiritilganlarni saqlash tugmasi -->
                <div>
                    <button type="submit"
                            name="news_update"
                            class="btn btn-primary">
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
require_once __DIR__ . '/../footer.php';