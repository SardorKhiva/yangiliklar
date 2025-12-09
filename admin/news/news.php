<?php
require_once __DIR__ . "/news_helper.php";     // mysql bazaga ulanish
require_once __DIR__ . '/../header.php';

$page = $_GET['page'] ?? 1;

$limit = $_POST['viewItemCount'] ?? $_GET['limit'] ?? 10;

?>
    <div class="container">
        <div class="row">
            <h1>Yangiliklar ro'yhati</h1>
        </div>
        <div class="mt-3 mb-3">
            <a href="/admin/news/add_news.php" class="btn btn-success">Qo'shish</a>
        </div>
        <table class="table table-dark table-hover table-striped">
            <thead>
            <tr>
                <th scope="col"> #</th>
                <th scope="col"> ID</th>
                <th scope="col"> Sarlavha</th>
                <th scope="col"> Mazmuni</th>
                <th scope="col"> Kategoriya</th>
                <th scope="col"> Muallif</th>
                <th scope="col"> Yozildi</th>
                <th scope="col"> Rasm</th>
                <th scope="col"> Amallar:</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach (getNewsList($page, $limit) as $newsItem): ?>
                <tr>
                    <th><?= $i++ ?></th>
                    <td> <?= $newsItem['id'] ?> </td>
                    <td> <?= $newsItem['news_title'] ?> </td>
                    <td>
                        <?= (mb_strlen($newsItem['content']) < 40) ? ($newsItem['content']) : (mb_substr($newsItem['content'], 0, 40) . '...') ?>
                    </td>
                    <td> <?= $newsItem['category_title'] ?> </td>
                    <td> <?= $newsItem['author'] ?> </td>
                    <td> <?= $newsItem['created_at'] ?> </td>
                    <td>
                        <img src="/uploads/news_img/<?= $newsItem['image']; ?>"
                             alt="<?= $newsItem['image'] ?>"
                             class="img-fluid img-thumbnail">
                    </td>
                    <td>
                        <a href="/admin/news/edit_news.php?id=<?= $newsItem['id']; ?>"
                           class="btn btn-primary">Tahrirlash</a>
                        <a href="/admin/news/delete_news.php?id=<?= $newsItem['id']; ?>"
                           class="btn btn-danger">O'chirish</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!--   Paginatsiya qismi     -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php for ($sahifa = 1; $sahifa <= getPaginationNews($limit); $sahifa++): ?>
                    <li class="page-item">
                        <a class="page-link <?php if ($sahifa == $_GET['page']) echo 'active'; ?>"
                           href="/admin/news/news.php?page= <?= $sahifa; ?>&limit=<?= $limit; ?>"> <?= $sahifa; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

        <form method="post" class="form-label pb-3">
            <select class="form-select" aria-label="Default select example" name="viewItemCount">
                <option selected>Nechtadan ma'lumot chiqsin</option>
                <?php for ($sahifa = 1;
                           $sahifa <= totalNewsRows();
                           $sahifa++): ?>
                    <option value="<?= $sahifa; ?>"
                            <?php if ($sahifa == $limit): ?>selected<?php endif; ?>>
                        <?= $sahifa ?>
                    </option>
                <?php endfor; ?>
            </select>
            <input type="submit"
                   name="inputItemCount"
                   value="Ko'rsatish"
                   class="btn btn-success mt-3">
        </form>

    </div>


<?php
require_once __DIR__ . '/../footer.php';