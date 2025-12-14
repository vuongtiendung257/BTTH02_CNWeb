<?php
// models/Category.php

require_once 'config/Database.php';

class Category {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    /**
     * Lấy tất cả danh mục
     * @return array
     */
    public function getAllCategories() {
        $query = "SELECT id, name FROM categories ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}