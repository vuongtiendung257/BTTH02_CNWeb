<?php require dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>

<div class="container">
    <h2>Khóa học của tôi</h2>

    <table class="table table-bordered">
        <tr>
            <th>Khóa học</th>
            <th>Tiến độ</th>
            <th>Trạng thái</th>
            <th></th>
        </tr>

        <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= $course['title'] ?></td>
            <td><?= $course['progress'] ?>%</td>
            <td>
                <?php
                if ($course['progress'] == 0) echo 'Chưa học';
                elseif ($course['progress'] < 100) echo 'Đang học';
                else echo 'Hoàn thành';
                ?>
            </td>
            <td>
                <a href="manage.php?action=progress&course_id=<?= $course['id'] ?>">
                    Xem tiến độ
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
