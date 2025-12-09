<?php

require_once __DIR__ . '/../../dbconnect.php';
function getNewsList(int $page = 1, int $limit = 5): array
{
    global $pdo;
//    $limit = 5;
    $offset = ($page - 1) * $limit;
    try {
        $sql = "SELECT 
                `p`.`id` AS `id`,
                `u`.`username` AS `author`,
                `c`.`title` AS `category_title`,
                `p`.`title` AS `news_title`,
                `p`.`content` AS `content`,
                `p`.`created_at` AS `created_at`,
                `p`.`updated_at` AS `updated_at`,
                `p`.`image` AS `image`,
                `p`.`visited_count` AS `visited_count`
                FROM `post` AS `p` 
                LEFT JOIN `user` AS `u` 
                    ON `u`.`id` = `p`.`author_id` 
                LEFT JOIN `category` AS `c`
                    ON `c`.`id` = `p`.`category_id`
                LIMIT :offset, :limit";
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

function addNews(string $title, string $content, int $category_id, int $author_id, string $image): void
{
    global $pdo;
    try {
        $sql_insert = "INSERT INTO `post` (`title`, `content`, `category_id`, `author_id`, `image`) 
                       VALUES (:title, :content, :category_id, :author_id, :image)";
        $statement = $pdo->prepare($sql_insert);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $statement->bindValue(':author_id', $author_id, PDO::PARAM_INT);
        $statement->bindValue(':image', $image);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    } finally {
        header('Location: /admin/news/news.php');
    }
}

function getPaginationNews(int $limit): int
{
    global $pdo;
    $sql = "SELECT * FROM `post`";
    $table = $pdo->prepare($sql);
    $table->execute();
    $total_rows = $table->rowCount();
    return ceil($total_rows / $limit);
}

function totalNewsRows(): int
{
    global $pdo;
    try {
        $sql = "SELECT COUNT(*) FROM `post`";
        $yangiliklar = $pdo->prepare($sql);
        $yangiliklar->execute();
        return $yangiliklar->fetchColumn();
    } catch (PDOException) {
        header('Location: /admin/news/news.php');
        exit;
    }
}


function getNewsById(int $id)
{
    global $pdo;
    try {
        $sql = "SELECT * FROM `post` WHERE `id` = :id";
        $yangiliklar = $pdo->prepare($sql);
        $yangiliklar->bindParam(':id', $id, PDO::PARAM_INT);
        $yangiliklar->execute();
        return $yangiliklar->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return [];
    }
}



function updateNews(int $id, string $title, string $content, int $category_id, int $author_id, string $image): void
{
    global $pdo;
    try {
        $sql = "UPDATE `post` 
                SET `title` = :title,
                    `content` = :content,
                    `category_id` = :category_id,
                    `author_id` = :author_id,
                    `image` = :image
                WHERE `id` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->bindValue(':image', $image);
        $stmt->execute();
    } catch (Throwable $th) {
        echo $th->getMessage();
    } finally {
        header('Location: /admin/news/news.php');
    }
}

function deleteNews(int $id): void
{
    global $pdo;
    try {
        $del = "DELETE FROM `post` 
                         WHERE `id` = :id";
        $stmt = $pdo->prepare($del);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: /admin/news/news.php');
    } catch (Throwable $th) {
        echo $th->getMessage();
        header('Location: /admin/news/news.php');
    } finally {
        exit;
    }
}