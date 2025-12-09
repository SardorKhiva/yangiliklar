<?php
/**
 * Foydalanuvchi: User
 * Loyiha nomi: yangiliklar.loc
 * Fayl nomi: category_helper.php
 * Fayl yaratilgan: 05.12.2025 8:15
 * Maqsad: baza bilan ishlovchi funksiyalar
 */

require_once __DIR__ . '/../../dbconnect.php';
function getCategoryList(int $page, int $limit = 5): array
{
    global $pdo;
//    $limit = 5;
    $offset = ($page - 1) * $limit;
    try {
        $sql = "SELECT * FROM `category` LIMIT :offset, :limit";
        $kategoriyalar = $pdo->prepare($sql);
        $kategoriyalar->bindValue(':offset', $offset, PDO::PARAM_INT);
        $kategoriyalar->bindValue(':limit', $limit, PDO::PARAM_INT);
        $kategoriyalar->execute();
        return $kategoriyalar->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return [];
    }
}

function allCategory(): array
{
    global $pdo;
    try {
        $sql = "SELECT * FROM `category`";
        $kategoriyalar = $pdo->prepare($sql);
        $kategoriyalar->execute();
        return $kategoriyalar->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException) {
        return [];
    }
}

function addCategory(string $title): void
{
    global $pdo;
    try {

        $sql_insert = "INSERT INTO `category` (`title`) VALUES (:title)";
        $statement = $pdo->prepare($sql_insert);
        $statement->bindparam(':title', $title);
        $statement->execute();
        header('Location: /admin/category.php');
        exit;
    } catch (PDOException $e) {
        echo "Kategoriya nomini kiritib bo'lmadi, qaytadan kiritib ko'ring!";
        echo "<br>";
        echo $e->getMessage();
        echo "<br>";
        header('Location: /admin/add_category.php');
    }
}

function getPaginationCategory(int $limit): int
{
    global $pdo;
    $sql = "SELECT * FROM `category`";
    $kategoriyalar = $pdo->prepare($sql);
    $kategoriyalar->execute();
    $total_rows = $kategoriyalar->rowCount();
    return ceil($total_rows / $limit);
}

function getCategoryTotalRows(): int
{
    global $pdo;
    try {
        $sql = "SELECT COUNT(*) FROM `category`";
        $kategoriyalar = $pdo->prepare($sql);
        $kategoriyalar->execute();
        return $kategoriyalar->fetchColumn();
    } catch (PDOException) {
        header('Location: /admin/category/category.php');
        exit;
    }
}

function getCategoryByNewsTitle(string $title)
{
    global $pdo;
    $sql = "SELECT * FROM `category` WHERE `title` = :title";
    $kategoriyalar = $pdo->prepare($sql);
    $kategoriyalar->bindParam(':title', $title);
    $kategoriyalar->execute();
    return $kategoriyalar->fetch(PDO::FETCH_ASSOC);
}

function getCategoryById(int $id)
{
    global $pdo;
    try {
        $sql = "SELECT * FROM `category` WHERE `id` = :id";
        $kategoriyalar = $pdo->prepare($sql);
        $kategoriyalar->bindParam(':id', $id, PDO::PARAM_INT);
        $kategoriyalar->execute();
        return $kategoriyalar->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo($e->getMessage());
        return [];
    }
}

function updateCategory(int $id, string $title): void
{
    global $pdo;
    try {
        $category_update_sql = "UPDATE `category` SET `title` = :title WHERE `id` = :id";
        $stmt = $pdo->prepare($category_update_sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: /admin/category.php');
        exit;
    } catch (Throwable $th) {
        echo $th->getMessage();
        header('Location: /admin/category.php');
        exit;
    }
}


function deleteCategory(int $id): void
{
    global $pdo;
    try {
        $del_category = "DELETE FROM `category` WHERE `id` = :id";
        $stmt = $pdo->prepare($del_category);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: /admin/category.php');
    } catch (Throwable $th) {
        echo $th->getMessage();
        header('Location: /admin/category.php');
    } finally {
        exit;
    }
}