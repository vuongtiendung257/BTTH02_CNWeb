<h2>Tiến độ khóa học</h2>

<p>Hoàn thành: <b><?= $progress['progress'] ?>%</b></p>

<p>
<?php
if ($progress['progress'] == 0) echo "📘 Chưa học";
elseif ($progress['progress'] < 100) echo "📗 Đang học";
else echo "✅ Hoàn thành";
?>
</p>

<a href="index.php?action=my_courses">Quay lại</a>
