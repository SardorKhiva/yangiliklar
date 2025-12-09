<?php
/** @var object $pdo */

require_once __DIR__ . '/../header.php';                   // saytni tepa qismi
require_once __DIR__ . '/news_helper.php';                 // yangiliklar bilan ishlovchi funksiyalar
require_once __DIR__ . '/../authors/users_helper.php';     // mualliflar bilan ishlovchi funksiya
include_once __DIR__ . '/../category/category_helper.php'; // kategoriyalar bilan ishlovchi funksiyalar
$authors = getAuthorsList();  // hamma author (user) larni olish

$upload_dir = __DIR__ . "/../../uploads/news_img/";  // rasmlar yuklanadigan joy
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (isset($_POST['news_add'])) {
    try {
        $title = trim($_POST['title']);
        $content = trim($_POST['news_content']);
        $category_id = trim($_POST['category_id']);
        $author_id = trim($_POST['author_id']);
        $image = $_FILES['image']['name'];
        addNews($title, $content, $category_id, $author_id, $image);
        move_uploaded_file($_FILES['image']['tmp_name'], ($upload_dir . $image));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

    <div class="container">
        <h2>Yangilik qo'shish</h2>
        <div class="row">
            <form method="post" enctype="multipart/form-data">
                <!-- Kiritish qismi -->
                <div class="mb-3">
                    <!-- Yangilik sarlavhasini kiritish -->
                    <div class="mt-3">
                        <label for="news_title"
                               class="form-label">Sarlavha
                        </label>
                        <input type="text"
                               class="form-control"
                               id="news_title"
                               placeholder="Sarlavhani kiriting"
                               name="title"
                               autofocus>
                    </div>

                    <!--     Yangilik kategoriyasini kiritish               -->
                    <div class="mt-3">
                        <label for="category_name_select"
                               class="form-label mt-3">
                            Kategoriya
                        </label>
                        <select id="category_name_select"
                                name="category_id"
                                class="form-select">
                            <option selected>
                                Kategoriyani tanlang
                            </option>
                            <?php foreach (allCategory() as $category): ?>
                                <option value="<?= $category['id']; ?>">
                                    <?= $category['title']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Yangilik muallifi -->
                    <div class="mt-3">
                        <label for="author"
                               class="form-label">
                            Muallif
                            <select class="form-select"
                                    name="author_id">
                                <?php foreach ($authors as $author): ?>
                                    <option selected>
                                        Muallifni tanlang
                                    </option>
                                    <option value="<?= $author['id'] ?>">
                                        <?= $author['username'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>

                    <!-- Yangilik mazmuni -->

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
                                rows="10">
                        </textarea>
                    </div>

                    <!-- Yangilik rasmi -->
                    <div class="mt-3">
                        <label for="image">
                            Yangilik rasmi
                        </label>
                        <input type="file"
                               name="image"
                               accept="image/jpeg, image/png, image/webp">
                    </div>

                </div>

                <!-- Kiritilganlarni saqlash tugmasi -->
                <div>
                    <button type="submit"
                            name="news_add"
                            class="btn btn-primary">
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php
require_once __DIR__ . '/../footer.php';