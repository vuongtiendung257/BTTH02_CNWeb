<h2><?= $course['title'] ?></h2>

<p><b>Mô tả:</b> <?= $course['description'] ?></p>
<p><b>Giảng viên:</b> <?= $course['instructor_name'] ?></p>
<p><b>Danh mục:</b> <?= $course['category_name'] ?></p>
<p><b>Thời lượng:</b> <?= $course['duration_weeks'] ?> tuần</p>
<p><b>Giá:</b> <?= number_format($course['price'], 0, ',', '.') ?> đ</p>

<hr>

<h3>Danh sách bài học</h3>

<?php if (empty($course['lessons'])): ?>
    <p>Khóa học chưa có bài học.</p>
<?php else: ?>
    <ol>
        <?php foreach ($course['lessons'] as $lesson): ?>
            <li>
                <?= $lesson['title'] ?>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

<hr>

<form method="POST" action="index.php?controller=enrollment&action=enroll">
    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
    <button type="submit">Đăng ký khóa học</button>
</form>
