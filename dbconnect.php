<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=news", "root", "1302");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print $e->getMessage();
}