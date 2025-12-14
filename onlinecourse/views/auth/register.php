
<?php
// views/auth/register.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS riêng -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<div class="register-card">
    <div class="register-header">
        <h2>Đăng ký tài khoản</h2>
        <p>Tham gia hệ thống khóa học online</p>
    </div>

    <div class="p-4">

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Đăng ký thành công! <a href="index.php?page=login" class="fw-bold">Đăng nhập ngay</a>
            </div>
        <?php endif; ?>

        <form action="index.php?page=register" method="POST">

            <div class="form-group mb-3">
                <i class="bi bi-person-fill input-group-text"></i>
                <input type="text" name="fullname" class="form-control" placeholder="Họ và tên" required>
            </div>

            <div class="form-group mb-3">
                <i class="bi bi-person-circle input-group-text"></i>
                <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required>
            </div>

            <div class="form-group mb-3">
                <i class="bi bi-envelope-fill input-group-text"></i>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="form-group mb-3">
                <i class="bi bi-lock-fill input-group-text"></i>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>

            <div class="form-group mb-4">
                <i class="bi bi-shield-lock-fill input-group-text"></i>
                <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu" required>
            </div>

            <button type="submit" class="btn btn-register w-100 text-white">
                <i class="bi bi-person-plus-fill me-1"></i> Đăng ký
            </button>
        </form>

        <div class="text-center mt-4 login-link">
            <span>Đã có tài khoản?</span>
            <a href="index.php?page=login">Đăng nhập</a>
        </div>
    </div>
</div>

</body>
</html>
>>>>>>> Stashed changes
