<?php
class Enrollment {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Kiểm tra đã đăng ký chưa
    public function isEnrolled($courseId, $studentId) {
        $stmt = $this->db->prepare(
            "SELECT id FROM enrollments 
             WHERE course_id = ? AND student_id = ?"
        );
        $stmt->execute([$courseId, $studentId]);
        return $stmt->fetch() ? true : false;
    }

    // Đăng ký khóa học
    public function enrollCourse($courseId, $studentId) {
        // Không cho đăng ký trùng
        if ($this->isEnrolled($courseId, $studentId)) {
            return false;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO enrollments (course_id, student_id, status, progress)
             VALUES (?, ?, 'active', 0)"
        );
        return $stmt->execute([$courseId, $studentId]);
    }

    // Lấy khóa học đã đăng ký (cho My Courses)
    public function getMyCourses($studentId) {
        $stmt = $this->db->prepare(
            "SELECT 
                c.*, 
                u.fullname AS instructor_name,
                cat.name AS category_name,
                e.progress,
                e.status
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            JOIN users u ON c.instructor_id = u.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE e.student_id = ?"
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }
}
