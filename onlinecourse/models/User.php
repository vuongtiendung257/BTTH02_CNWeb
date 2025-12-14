<?php
// models/User.php

require_once __DIR__ . '/../config/Database.php';

class User 
{
    private $db;

    public function __construct() 
    {
        $this->db = Database::getInstance();
        
    }

    // Kiểm tra email đã tồn tại chưa
    public function findByEmail($email) 
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // Kiểm tra username đã tồn tại chưa
    public function findByUsername($username) 
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    // Tạo user mới (đăng ký)
    public function register($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password, fullname, role, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        return $stmt->execute([
            $data['username'],
            $data['email'],
            $data['password'],      // đã được hash rồi
            $data['fullname'],
            0                       // role = 0: học viên mặc định
        ]);
    }

    // Các hàm sau này sẽ dùng (đăng nhập, lấy thông tin user...)
    public function findById($id) 
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}