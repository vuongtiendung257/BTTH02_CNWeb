<h1>Danh sách khóa học</h1>
<h2>
    <a href="index.php?controller=enrollment&action=myCourses">
        <button type="button">📚 Khóa học của tôi</button>
    </a>
</h2><form method="GET">
    <input type="hidden" name="controller" value="course">
    <input type="hidden" name="action" value="index">

    <input type="text" name="keyword" placeholder="Tìm kiếm khóa học..."
           value="<?= $_GET['keyword'] ?? '' ?>">

    <select name="category_id">
        <option value="">Tất cả danh mục</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"
                <?= (($_GET['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                <?= $cat['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">🔍 Tìm kiếm</button>
    
</form>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>Khóa học</th>
        <th>Giảng viên</th>
        <th>Danh mục</th>
        <th>Giá</th>
        <th>Thời lượng</th>
        <th>Hành động</th>
        
    </tr>

    <?php foreach ($courses as $c): ?>
    <tr>
        <td><b><?= $c['title'] ?></b></td>
        <td><?= $c['instructor_name'] ?></td>
        <td><?= $c['category_name'] ?></td>
        <td style="color:red"><?= number_format($c['price'], 0, ',', '.') ?>đ</td>
        <td><?= $c['duration_weeks'] ?> tuần</td>
        <td>
            <a href="index.php?controller=course&action=detail&id=<?= $c['id'] ?>">Xem</a>
            |
            <form method="POST" action="index.php?controller=enrollment&action=enroll" style="display:inline;">
                <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
                <button type="submit">Đăng ký</button>
            </form>

        </td>
    </tr>
    <?php endforeach; ?>
</table>
