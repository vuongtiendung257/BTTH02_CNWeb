<h2><?= $course['title'] ?></h2>

<p><?= $course['description'] ?></p>
<p>Giá: <b><?= number_format($course['price'], 0, ',', '.') ?>đ</b></p>
<p>Thời lượng: <?= $course['duration_weeks'] ?> tuần</p>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 0): ?>
    <?php if (!$enrolled): ?>
        <a href="index.php?controller=enrollment&action=enroll&course_id=<?= $course['id'] ?>">
            👉 Đăng ký học
        </a>
    <?php else: ?>
        <p><b>✅ Bạn đã đăng ký khóa học này</b></p>
    <?php endif; ?>
<?php endif; ?>

<h3>Bài học</h3>
<ul>
<?php foreach ($lessons as $lesson): ?>
    <li><?= $lesson['title'] ?></li>
<?php endforeach; ?>
</ul>
