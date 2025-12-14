<?php

class Database {
    private static $host = 'localhost';
    private static $db_name = 'onlinecourse';
    private static $username = 'root'; // Thay đổi nếu cần
    private static $password = '';     // Thay đổi nếu cần
    private static $conn = null;

    /**
     * Lấy kết nối PDO
     * @return PDO
     */
    public static function getConnection() {
        if (self::$conn === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4";
                self::$conn = new PDO($dsn, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                echo "Lỗi kết nối CSDL: " . $exception->getMessage();
                exit();
            }
        }
        return self::$conn;
    }
}