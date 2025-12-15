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
        // Nếu không phải POST thì hiển thị form
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
        {
            require_once __DIR__ . '/../views/auth/register.php';
            return;
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

        // Kiểm tra trùng nếu chưa có lỗi validate cơ bản
        if (empty($errors)) 
        {
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
            // Lưu lỗi vào session và quay lại form
            $_SESSION['register_errors'] = $errors;
            $_SESSION['old_input'] = $_POST; // để giữ lại dữ liệu đã nhập
            header("Location: index.php?page=register");
            exit;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $username,
            'email'    => $email,
            'password' => $hashedPassword,
            'fullname' => $fullname
        ];

        if ($this->userModel->register($data)) 
        {
            // KHÔNG tự động đăng nhập nữa
            // Chỉ thông báo thành công và chuyển về trang login
            $_SESSION['success_message'] = "Đăng ký tài khoản thành công! Vui lòng đăng nhập để tiếp tục.";

            header("Location: index.php?page=login");
            exit;
        } 
        else 
        {
            $_SESSION['register_errors'] = ["Đăng ký thất bại, vui lòng thử lại sau."];
            $_SESSION['old_input'] = $_POST;
            header("Location: index.php?page=register");
            exit;
        }
    }

    public function login() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
        {
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($login) || empty($password)) 
        {
            $_SESSION['login_error'] = "Email/tên đăng nhập và mật khẩu không được để trống";
            header("Location: index.php?page=login");
            exit;
        }

        $user = $this->userModel->findByEmail($login);
        if (!$user) 
        {
            $user = $this->userModel->findByUsername($login);
        }

        if (!$user || !password_verify($password, $user['password'])) 
        {
            $_SESSION['login_error'] = "Tài khoản hoặc mật khẩu không đúng";
            header("Location: index.php?page=login");
            exit;
        }

        // Đăng nhập thành công
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['fullname']  = $user['fullname'];
        $_SESSION['role']      = $user['role'];

        switch ($user['role']) 
        {
            case 0:
                header("Location: index.php?page=student/dashboard");
                break;
            case 1:
                header("Location: index.php?page=instructor/dashboard");
                break;
            case 2:
                header("Location: index.php?page=admin/dashboard");
                break;
            default:
                header("Location: index.php?page=home");
                break;
        }
        exit;
    }

    public function logout() 
    {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}