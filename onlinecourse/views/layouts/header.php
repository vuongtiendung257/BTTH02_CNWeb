<?php
if (!empty($hideHeader)) return;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Quản lý Khóa học Online</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
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
