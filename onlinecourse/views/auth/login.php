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
        <!-- ================= FORM LOGIN (dùng class register-form để lấy style sẵn có) ================= -->
        <div class="auth-form register-form">  <!-- ĐỔI THÀNH register-form ĐỂ HIỂN THỊ ĐÚNG -->
            <h2 class="auth-title">Đăng nhập</h2>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message" style="color: red; margin: 15px 0; text-align: center; font-size: 14px;">
                    <?= htmlspecialchars(urldecode($_GET['error'])) ?>
                </div>
            <?php endif; ?>

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

        <!-- ================= VISUAL (giữ nguyên như trang đăng ký) ================= -->
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