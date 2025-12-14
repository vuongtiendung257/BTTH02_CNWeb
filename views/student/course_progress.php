<?php include '../layouts/header.php'; 

$course_id = $_GET['id'] ?? 0;
if ($course_id <= 0) {
    header('Location: my_courses.php');
    exit();
}

$enrollmentModel = new Enrollment(Database::getInstance());
$courseModel = new Course(Database::getInstance());

$enrollment = $enrollmentModel->getEnrollment($course_id, $_SESSION['user_id']);
$course = $courseModel->getDetail($course_id);
$lessons = $courseModel->getLessonsByCourse($course_id);

// Giả lập update progress khi xem trang này (thực tế sẽ update khi học viên click "Hoàn thành bài")
// $completed_lessons = rand(0, count($lessons)); // Thay bằng logic thật sau
// $new_progress = count($lessons) > 0 ? round(($completed_lessons / count($lessons)) * 100) : 0;

// if ($new_progress > $enrollment['progress']) {
//     $enrollmentModel->updateProgress($course_id, $_SESSION['user_id'], $new_progress);
//     $enrollment['progress'] = $new_progress;
// }
?>

<div class="container py-5">
    <h1 class="mb-4"><?= htmlspecialchars($course['title']) ?></h1>
    <p class="lead">Tiến độ học tập của bạn</p>

    <div class="card mb-5">
        <div class="card-body">
            <p class="fs-3 fw-bold">Tiến độ: <?= $enrollment['progress'] ?>%</p>
            <div class="progress" style="height: 30px;">
                <div class="progress-bar bg-success progress-bar-striped" style="width: <?= $enrollment['progress'] ?>%">
                    <?= $enrollment['progress'] ?>%
                </div>
            </div>
        </div>
    </div>

    <h3>Danh sách bài học</h3>
    <?php if (empty($lessons)): ?>
        <p>Khóa học chưa có bài học nào.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($lessons as $index => $lesson): ?>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Bài <?= $lesson['order_num'] ?>: <?= htmlspecialchars($lesson['title']) ?></h5>
                        <small class="text-success">Hoàn thành</small> <!-- Thay bằng logic thật -->
                    </div>
                    <p class="mb-1"><?= htmlspecialchars($lesson['content'] ?? 'Nội dung bài học') ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../layouts/footer.php'; ?>