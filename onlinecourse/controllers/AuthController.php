<?php
// controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController 
{
    private $userModel;

    public function __construct() 
    {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
        {
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

        if (empty($errors)) 
        {
            // Kiểm tra trùng username/email
            if ($this->userModel->findByUsername($username))
            {
                $errors[] = "Tên đăng nhập đã tồn tại";
            }
            if ($this->userModel->findByEmail($email)) 
            {
                $errors[] = "Email đã tồn tại";
            }
        }

        if (!empty($errors)) 
        {
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

        if ($this->userModel->register($data)) 
        {
            header("Location: index.php?page=register&success=1");
        } 
        else 
        {
            header("Location: index.php?page=register&error=Đăng ký thất bại, vui lòng thử lại");
        }
        exit;
    }

    public function login() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
        {
            header('Location: index.php?page=login');
            exit;
        }

        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($login) || empty($password)) 
        {
            header("Location: index.php?page=login&error=Email/tên đăng nhập và mật khẩu không được để trống");
            exit;
        }

        // Tìm user theo email hoặc username
        $user = $this->userModel->findByEmail($login);
        if (!$user) 
        {
            $user = $this->userModel->findByUsername($login);
        }

        if (!$user || !password_verify($password, $user['password'])) 
        {
            header("Location: index.php?page=login&error=Tài khoản hoặc mật khẩu không đúng");
            exit;
        }

        // Đăng nhập thành công - lưu session
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['fullname']  = $user['fullname'];
        $_SESSION['role']      = $user['role'];

        // Redirect theo role
        switch ($user['role']) 
        {
            case 0: // Học viên
                header("Location: index.php?page=student/dashboard");
                break;
            case 1: // Giảng viên
                header("Location: index.php?page=instructor/dashboard");
                break;
            case 2: // Quản trị viên
                header("Location: index.php?page=admin/dashboard");
                break;
            default:
                header("Location: index.php?page=login");
                break;
        }
        exit;
    }
}