<?php
// views/student/my_courses.php

session_start();

// Kiểm tra đăng nhập và role học viên
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
    header('Location: ../auth/login.php');
    exit();
}

// Require Database và Model
require_once '../../config/Database.php';
require_once '../../models/Enrollment.php';
require_once '../../models/Course.php';  // nếu cần dùng Course

$db = Database::getInstance();
$enrollmentModel = new Enrollment($db);

// Lấy khóa học đã đăng ký của học viên hiện tại
$courses = $enrollmentModel->getMyEnrolledCourses($_SESSION['user_id']);
 include '../layouts/header.php'; 

$enrollmentModel = new Enrollment(Database::getInstance());
$courses = $enrollmentModel->getMyEnrolledCourses($_SESSION['user_id']);
?>

<div class="container py-5">
    <h1 class="mb-5 text-center fw-bold">Khóa học của tôi</h1>

    <?php if (empty($courses)): ?>
        <div class="text-center py-5">
            <h4 class="text-muted">Bạn chưa đăng ký khóa học nào.</h4>
            <a href="../courses/index.php" class="btn btn-primary btn-lg">Khám phá khóa học</a>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="../../assets/uploads/courses/default.jpg" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                            <p class="text-muted">Giảng viên: <?= htmlspecialchars($course['instructor_name']) ?></p>
                            <div class="mt-auto">
                                <p class="mb-2 fw-bold">Tiến độ: <?= $course['progress'] ?>%</p>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-success" style="width: <?= $course['progress'] ?>%"></div>
                                </div>
                                <a href="course_progress.php?id=<?= $course['id'] ?>" class="btn btn-primary w-100">Vào học</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../layouts/footer.php'; ?>