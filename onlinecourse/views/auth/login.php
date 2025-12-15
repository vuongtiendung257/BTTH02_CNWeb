<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="auth-page">
<div class="auth-wrapper">
    <div class="auth-container" id="authBox">
        <!-- ================= FORM LOGIN ================= -->
        <div class="auth-form register-form">
            <h2 class="auth-title">Đăng nhập</h2>

            <!-- Thông báo thành công từ đăng ký -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success" style="margin-bottom: 20px; border-radius: 8px;">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($_SESSION['success_message']) ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- Thông báo lỗi đăng nhập (nếu có) -->
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px; border-radius: 8px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= htmlspecialchars($_SESSION['login_error']) ?>
                </div>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>

            <!-- Xóa phần cũ dùng $_GET['error'] vì giờ dùng session -->

            <form action="index.php?page=login" method="POST">
                <div class="form-group">
                    <input type="text" name="login" required>
                    <label>Email hoặc Tên đăng nhập</label>
                    <span class="input-icon"><i class="fa fa-user"></i></span>
                </div>
                <div class="form-group">
                    <input type="password" name="password" required>
                    <label>Mật khẩu</label>
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                </div>
                <button class="btn-auth">Đăng nhập</button>
            </form>
            <div class="auth-link">
                Chưa có tài khoản?
                <a href="index.php?page=register">Đăng ký</a>
            </div>
        </div>

        <!-- ================= VISUAL ================= -->
        <div class="auth-visual">
            <img src="assets/images/chismos.jpg" alt="Study">
            <div class="auth-visual-text">
                <h3>Online Course</h3>
                <p>Học tập mọi lúc, mọi nơi</p>
            </div>
        </div>
    </div>
</div>

<footer>
    © 2025 - Online Course
</footer>

<script src="assets/js/auth.js"></script>
</body>
</html>