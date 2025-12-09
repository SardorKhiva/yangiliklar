<?php
/**
 * Foydalanuvchi: User
 * Loyiha nomi: yangiliklar.loc
 * Fayl nomi: users_helper.php
 * Fayl yaratilgan: 07.12.2025 15:37
 * Maqsad:
 */
require_once __DIR__ . '/../../dbconnect.php';

function getAuthorsList(): array
{
    global $pdo;
    try {
        $sql = 'SELECT * FROM `user`';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function getAuthorById(int $id): array
{
    global $pdo;
    try {
        $sql = 'SELECT * FROM `user` 
                WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}