<?php
// views/layouts/header.php
// KHÔNG session_start() ở đây (session đã start trong index.php)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Quản lý Khóa học Online</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        header { background: #333; color: white; padding: 15px; text-align: center; }
        nav { background: #444; padding: 10px; }
        nav a { color: white; margin: 0 15px; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .logout { float: right; }
    </style>
</head>
<body>

<header>
    <h1>Website Quản lý Khóa học Online</h1>
</header>

<nav>
    <a href="index.php?page=home">Trang chủ</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <span>Xin chào, <?= htmlspecialchars($_SESSION['fullname']) ?></span>

        <?php if ($_SESSION['role'] == 0): ?>
            <a href="index.php?page=student/dashboard">Dashboard Học viên</a>
            <a href="index.php?page=student/my_courses">Khóa học của tôi</a>

        <?php elseif ($_SESSION['role'] == 1): ?>
            <a href="index.php?page=instructor/dashboard">Dashboard Giảng viên</a>
            <a href="index.php?page=instructor/my_courses">Quản lý khóa học</a>

        <?php elseif ($_SESSION['role'] == 2): ?>
            <a href="index.php?page=admin/dashboard">Dashboard Admin</a>
            <a href="index.php?page=admin/users">Quản lý người dùng</a>
        <?php endif; ?>

        <a href="index.php?page=logout" class="logout">Đăng xuất</a>
    <?php else: ?>
        <a href="index.php?page=login">Đăng nhập</a>
        <a href="index.php?page=register">Đăng ký</a>
    <?php endif; ?>
</nav>

<div class="container">
