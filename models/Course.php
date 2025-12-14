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
    // Lấy tất cả khóa học công khai cho học viên
// Lấy tất cả khóa học công khai
public function getAllCourses($search = '', $category_id = null) {
    $sql = "SELECT c.*, cat.name AS category_name, u.fullname AS instructor_name
            FROM courses c
            LEFT JOIN categories cat ON c.category_id = cat.id
            LEFT JOIN users u ON c.instructor_id = u.id
            WHERE 1=1";  // Để dễ thêm điều kiện

    $params = [];

    if (!empty($search)) {
        $sql .= " AND c.title LIKE ?";
        $params[] = '%' . $search . '%';
    }

    if ($category_id !== null && $category_id !== '') {
        $sql .= " AND c.category_id = ?";
        $params[] = $category_id;
    }

    $sql .= " ORDER BY c.created_at DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Chi tiết khóa học
public function getDetail($id) {
    $stmt = $this->db->prepare("SELECT c.*, cat.name AS category_name, u.fullname AS instructor_name
                                FROM courses c
                                LEFT JOIN categories cat ON c.category_id = cat.id
                                LEFT JOIN users u ON c.instructor_id = u.id
                                WHERE c.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Các method countEnrollments, countLessons, getLessonsByCourse như trước

// Đếm số học viên
public function countEnrollments($course_id) {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM enrollments WHERE course_id = ? AND status = 'active'");
    $stmt->execute([$course_id]);
    return $stmt->fetchColumn();
}

// Đếm số bài học
public function countLessons($course_id) {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM lessons WHERE course_id = ?");
    $stmt->execute([$course_id]);
    return $stmt->fetchColumn();
}

// Lấy bài học cho progress
public function getLessonsByCourse($course_id) {
    $stmt = $this->db->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY order_num ASC");
    $stmt->execute([$course_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>