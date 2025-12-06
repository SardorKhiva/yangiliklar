<?php
require_once __DIR__ . "/../db_helper.php";     // mysql bazaga ulanish
require_once __DIR__ . '/header.php';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
?>
    <div class="container">
        <div class="row">
            <h1>Kategoriyalar ro'yhati</h1>
        </div>
        <div class="mt-3 mb-3">
            <a href="/admin/add_category.php" class="btn btn-success">Qo'shish</a>
        </div>
        <table class="table table-dark table-hover table-striped">
            <thead>
            <tr>
                <th scope="col"> ID</th>
                <th scope="col"> Nomi:</th>
                <th scope="col"> Amallar:</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (getCategoryList($page) as $kategoriya): ?>
                <tr>
                    <td> <?= $kategoriya['id'] ?> </td>
                    <td> <?= $kategoriya['title'] ?> </td>
                    <td>
                        <a href="/admin/edit_category.php?id=<?= $kategoriya['id']; ?>" class="btn btn-primary">Tahrirlash</a>
                        <a href="/admin/delete_category.php?id=<?= $kategoriya['id']; ?>" class="btn btn-danger">O'chirish</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php for ($sahifa = 1; $sahifa <= getPagination(); $sahifa++): ?>
                    <li class="page-item">
                        <a class="page-link <?php if ($sahifa == $_GET['page']) echo 'active'; ?>"
                           href="/admin/category.php?page=<?= $sahifa ?>"><?= $sahifa ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    </div>


<?php
require_once __DIR__ . '/footer.php';