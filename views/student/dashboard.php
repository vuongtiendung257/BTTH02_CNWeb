<?php include '../layouts/header.php'; ?>

<div class="container py-5">
    <!-- Chào mừng + thông tin cá nhân -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold text-primary">
                Xin chào, <?= htmlspecialchars($_SESSION['fullname'] ?? 'Học viên') ?>! 👋
            </h1>
            <p class="lead text-muted mt-3">
                Chào mừng bạn trở lại khu vực học tập. Hãy tiếp tục hành trình chinh phục kiến thức mới hôm nay!
            </p>
        </div>
    </div>

    <!-- Thống kê nhanh -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 bg-gradient-primary text-white">
                <div class="display-4 fw-bold"><?= $totalEnrolled ?? 0 ?></div>
                <p class="mb-0 fs-5">Khóa học đang học</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 bg-gradient-success text-white">
                <div class="display-4 fw-bold"><?= $totalCompleted ?? 0 ?></div>
                <p class="mb-0 fs-5">Khóa học đã hoàn thành</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 bg-gradient-warning text-white">
                <div class="display-4 fw-bold"><?= $totalProgress ?? '0%' ?></div>
                <p class="mb-0 fs-5">Tiến độ trung bình</p>
            </div>
        </div>
    </div>

    <!-- Nút hành động nhanh -->
    <div class="row mb-5">
        <div class="col-md-6 mb-3">
            <a href="../courses/index.php" class="btn btn-primary btn-lg w-100 py-3 shadow-sm">
                <i class="bi bi-search me-2"></i> Khám phá khóa học mới
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="../student/my_courses.php" class="btn btn-success btn-lg w-100 py-3 shadow-sm">
                <i class="bi bi-book me-2"></i> Khóa học của tôi
            </a>
        </div>
    </div>

    <!-- Khóa học đang học gần đây -->
    <?php if (!empty($recentCourses)): ?>
    <h3 class="mb-4">Tiếp tục học</h3>
    <div class="row g-4">
        <?php foreach ($recentCourses as $course): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                <img src="../assets/uploads/courses/<?= htmlspecialchars($course['image'] ?? 'default.jpg') ?>" 
                     class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" 
                     style="height: 180px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold"><?= htmlspecialchars($course['title']) ?></h5>
                    <p class="text-muted small">
                        <i class="bi bi-person-fill"></i> <?= htmlspecialchars($course['instructor_name']) ?>
                    </p>

                    <!-- Progress bar -->
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Tiến độ</span>
                            <span class="fw-bold"><?= $course['progress'] ?>%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" 
                                 style="width: <?= $course['progress'] ?>%"></div>
                        </div>
                    </div>

                    <a href="../courses/detail.php?id=<?= $course['id'] ?>" 
                       class="btn btn-outline-primary mt-4">
                        <?= $course['progress'] > 0 ? 'Tiếp tục học' : 'Bắt đầu học' ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-5 bg-light rounded-3">
        <h4 class="text-muted">Bạn chưa đăng ký khóa học nào</h4>
        <p>Hãy khám phá và đăng ký ngay để bắt đầu hành trình học tập!</p>
        <a href="../courses/index.php" class="btn btn-primary btn-lg mt-3">Xem tất cả khóa học</a>
    </div>
    <?php endif; ?>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745, #1e7e34);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
    }
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
</style>

<?php include '../layouts/footer.php'; ?>