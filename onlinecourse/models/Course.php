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
     public function getAll() {
        $stmt = $this->db->query(
            "SELECT
                c.*, u.fullname AS instructor_name, cat.name AS category_name
            FROM courses c
            JOIN users u ON c.instructor_id = u.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE c.status = 'approved'"
        );
        return $stmt->fetchAll();
    }

    // Tìm kiếm khóa học
    public function search($keyword = '', $categoryId = null)
    {
        $sql = "
            SELECT 
                c.*,
                u.fullname AS instructor_name,
                cat.name AS category_name
            FROM courses c
            JOIN users u ON c.instructor_id = u.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE c.status = 'approved'
        ";

        $params = [];

        // Tìm theo từ khóa
        if (!empty($keyword)) {
            $sql .= " AND c.title LIKE ? ";
            $params[] = '%' . $keyword . '%';
        }

        // Lọc theo danh mục
        if (!empty($categoryId)) {
            $sql .= " AND c.category_id = ? ";
            $params[] = $categoryId;
        }

        $sql .= " ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }


    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll();
    }

    // Lấy chi tiết khóa học + giảng viên + danh mục
    // Lấy chi tiết khóa học + giảng viên + danh mục
    public function getDetailWithLessons($courseId)
    {
        // Lấy thông tin khóa học
        $stmt = $this->db->prepare("
            SELECT 
                c.*,
                u.fullname AS instructor_name,
                cat.name AS category_name
            FROM courses c
            JOIN users u ON c.instructor_id = u.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE c.id = ? AND c.status = 'approved'
        ");
        $stmt->execute([$courseId]);
        $course = $stmt->fetch();

        if (!$course) return null;

        // Lấy danh sách bài học
        $stmtLessons = $this->db->prepare("
            SELECT id, title, order_num
            FROM lessons
            WHERE course_id = ?
            ORDER BY order_num ASC
        ");
        $stmtLessons->execute([$courseId]);
        $course['lessons'] = $stmtLessons->fetchAll();

        return $course;
    }


}
?>