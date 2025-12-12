<?php
// config/Database.php

class Database 
{
    private static $instance = null;
    private $conn;

    // Thay đổi thông tin kết nối theo máy bạn
    private $host = 'localhost';
    private $dbname = 'onlinecourse';    // database name
    private $username = 'root';          // username MySQL 
    private $password = '';              // password MySQL 

    private function __construct() 
    {
        try 
        {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        }
        catch (PDOException $e) 
        {
            die("Kết nối database thất bại: " . $e->getMessage());
        }
    }

    public static function getInstance() 
    {
        if (self::$instance === null) 
        {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}