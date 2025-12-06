<?php
require_once __DIR__ . "/category_helper.php";     // mysql bazaga ulanish
require_once __DIR__ . '/../header.php';

$page = $_GET['page'] ?? 1;

$limit = $_POST['viewItemCount'] ?? $_GET['limit'] ?? 10;
/*
echo "POST massivi: <br>";
echo "<pre>";
print_r($_POST);
echo "<hr>";

echo "GET massivi: <br>";
print_r($_GET);
echo "</pre>";
echo "<hr>";
*/
?>
    <div class="container">
        <div class="row">
            <h1>Kategoriyalar ro'yhati</h1>
        </div>
        <div class="mt-3 mb-3">
            <a href="/admin/category/add_category.php" class="btn btn-success">Qo'shish</a>
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
            <?php foreach (getCategoryList($page, $limit) as $kategoriya): ?>
                <tr>
                    <td> <?= $kategoriya['id'] ?> </td>
                    <td> <?= $kategoriya['title'] ?> </td>
                    <td>
                        <a href="/admin/category/edit_category.php?id=<?= $kategoriya['id']; ?>"
                           class="btn btn-primary">Tahrirlash</a>
                        <a href="/admin/category/delete_category.php?id=<?= $kategoriya['id']; ?>"
                           class="btn btn-danger">O'chirish</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!--   Paginatsiya qismi     -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php for ($sahifa = 1; $sahifa <= getPagination($limit); $sahifa++): ?>
                    <li class="page-item">
                        <a class="page-link <?php if ($sahifa == $_GET['page']) echo 'active'; ?>"
                           href="/admin/category/category.php?page= <?= $sahifa; ?>&limit=<?= $limit; ?>"> <?= $sahifa; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>


        <form method="post" class="form-label pb-3">
            <select class="form-select" aria-label="Default select example" name="viewItemCount">
                <option selected>Nechtadan ma'lumot chiqsin</option>
                <?php for ($sahifa = 1;
                           $sahifa <= totalRows();
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