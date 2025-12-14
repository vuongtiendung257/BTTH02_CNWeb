<h2>Tiến độ học tập</h2>

<p><b>Khóa học:</b> <?= $course['title'] ?></p>
<p><b>Hoàn thành:</b> <?= $progress ?>%</p>

<h3>Bài học</h3>
<ul>
<?php foreach ($lessons as $lesson): ?>
    <li>
        <?= $lesson['title'] ?>
        |
        <a href="index.php?controller=enrollment&action=updateProgress&course_id=<?= $course['id'] ?>">
            ✔ Đã học
        </a>
    </li>
<?php endforeach; ?>
</ul>
