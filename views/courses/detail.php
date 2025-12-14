<?php include '../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-4"><?= htmlspecialchars($course['title']) ?></h1>
            <p class="lead text-muted">Giảng viên: <strong><?= htmlspecialchars($course['instructor_name']) ?></strong></p>
            <div class="mb-4">
                <span class="badge bg-secondary fs-6 me-2"><?= htmlspecialchars($course['category_name']) ?></span>
                <span class="badge bg-info fs-6 me-2"><?= $course['level'] ?></span>
                <span class="badge bg-success fs-6"><?= $lesson_count ?> bài học</span>
            </div>
            <p class="fs-3 fw-bold text-primary mb-4"><?= number_format($course['price']) ?> ₫</p>
            <p class="fs-5 mb-4">Thời lượng: <?= $course['duration_weeks'] ?> tuần</p>
            <p class="fs-5 mb-4">Số học viên đã đăng ký: <strong><?= $enrolled_count ?></strong></p>

            <hr class="my-5">

            <h3>Mô tả khóa học</h3>
            <p class="lead"><?= nl2br(htmlspecialchars($course['description'])) ?></p>
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 100px;">
                <div class="card-body text-center">
                    <?php if ($is_enrolled): ?>
                        <div class="alert alert-success">
                            <strong>Bạn đã đăng ký khóa học này!</strong>
                        </div>
                        <a href="../student/course_progress.php?id=<?= $course['id'] ?>" class="btn btn-success btn-lg w-100">
                            Vào học ngay
                        </a>
                    <?php else: ?>
                        <p class="fs-4 fw-bold mb-4">Đăng ký ngay hôm nay!</p>
                        <a href="../controllers/EnrollmentController.php?action=enroll&id=<?= $course['id'] ?>" class="btn btn-primary btn-lg w-100">
                            Đăng ký học
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>