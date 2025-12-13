<?php
class Course {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lấy tất cả khóa học của giảng viên hiện tại
    public function getMyCourses($instructor_id) {
        $stmt = $this->db->prepare("SELECT c.*, cat.name AS category_name 
                                    FROM courses c 
                                    LEFT JOIN categories cat ON c.category_id = cat.id 
                                    WHERE c.instructor_id = ? 
                                    ORDER BY c.created_at DESC");
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy một khóa học theo id (chỉ nếu thuộc về giảng viên)
    public function getById($id, $instructor_id) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = ? AND instructor_id = ?");
        $stmt->execute([$id, $instructor_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo khóa học mới
    public function create($data, $instructor_id) {
        $stmt = $this->db->prepare("INSERT INTO courses 
            (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        return $stmt->execute([
            $data['title'],
            $data['description'],
            $instructor_id,
            $data['category_id'],
            $data['price'],
            $data['duration_weeks'],
            $data['level'],
            $data['image'] ?? 'default.jpg'  // nếu không upload ảnh thì dùng mặc định
        ]);
    }

    // Cập nhật khóa học
    public function update($id, $data, $instructor_id) {
        $stmt = $this->db->prepare("UPDATE courses SET 
            title = ?, description = ?, category_id = ?, price = ?, 
            duration_weeks = ?, level = ?, image = ?, updated_at = NOW() 
            WHERE id = ? AND instructor_id = ?");

        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['category_id'],
            $data['price'],
            $data['duration_weeks'],
            $data['level'],
            $data['image'] ?? null,
            $id,
            $instructor_id
        ]);
    }

    // Xóa khóa học (chỉ nếu thuộc về mình)
    public function delete($id, $instructor_id) {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = ? AND instructor_id = ?");
        return $stmt->execute([$id, $instructor_id]);
    }
}
?>