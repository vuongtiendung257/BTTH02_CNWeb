<?php
// controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }

        $fullname = trim($_POST['fullname'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        $errors = [];

        if (empty($fullname)) $errors[] = "Họ và tên không được để trống";
        if (empty($username)) $errors[] = "Tên đăng nhập không được để trống";
        if (empty($email)) $errors[] = "Email không được để trống";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ";
        if (empty($password)) $errors[] = "Mật khẩu không được để trống";
        if ($password !== $confirm) $errors[] = "Mật khẩu xác nhận không khớp";

        if (empty($errors)) {
            // Kiểm tra trùng username/email
            if ($this->userModel->findByUsername($username)) {
                $errors[] = "Tên đăng nhập đã tồn tại";
            }
            if ($this->userModel->findByEmail($email)) {
                $errors[] = "Email đã tồn tại";
            }
        }

        if (!empty($errors)) {
            // Quay lại form kèm lỗi
            $errorMsg = implode('<br>', $errors);
            header("Location: index.php?page=register&error=" . urlencode($errorMsg));
            exit;
        }

        // Hash password và lưu user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $username,
            'email'    => $email,
            'password' => $hashedPassword,
            'fullname' => $fullname
        ];

        if ($this->userModel->register($data)) {
            header("Location: index.php?page=register&success=1");
        } else {
            header("Location: index.php?page=register&error=Đăng ký thất bại, vui lòng thử lại");
        }
        exit;
    }
}