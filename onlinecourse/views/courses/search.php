<h2>Kết quả tìm kiếm khóa học</h2>

<?php if (empty($courses)): ?>
    <p>❌ Không tìm thấy khóa học phù hợp.</p>
<?php else: ?>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>Khóa học</th>
        <th>Giảng viên</th>
        <th>Giá</th>
        <th>Thời lượng</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($courses as $course): ?>
        <tr>
            <td><strong><?= htmlspecialchars($course['title']) ?></strong></td>
            <td><?= htmlspecialchars($course['instructor_name']) ?></td>
            <td style="color:red">
                <?= number_format($course['price'], 0, ',', '.') ?>đ
            </td>
            <td><?= $course['duration_weeks'] ?> tuần</td>
            <td>
                <a href="manage.php?controller=course&action=show&id=<?= $course['id'] ?>">
                    Xem
                </a>
                |
                <form method="POST"
                      action="manage.php?controller=enrollment&action=enroll"
                      style="display:inline;">
                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                    <button type="submit">Đăng ký</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php endif; ?>