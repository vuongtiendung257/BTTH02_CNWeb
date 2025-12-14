<?php
class Enrollment {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function isEnrolled($course_id, $student_id) {
        $stmt = $this->db->prepare("SELECT 1 FROM enrollments WHERE course_id = ? AND student_id = ?");
        $stmt->execute([$course_id, $student_id]);
        return $stmt->fetch() !== false;
    }

    public function enroll($course_id, $student_id) {
        $stmt = $this->db->prepare("INSERT IGNORE INTO enrollments (course_id, student_id, enrolled_date, status, progress) VALUES (?, ?, NOW(), 'active', 0)");
        return $stmt->execute([$course_id, $student_id]);
    }

    public function getMyEnrolledCourses($student_id) {
        $stmt = $this->db->prepare("SELECT c.*, e.progress, cat.name AS category_name, u.fullname AS instructor_name
                                    FROM enrollments e
                                    JOIN courses c ON e.course_id = c.id
                                    LEFT JOIN categories cat ON c.category_id = cat.id
                                    LEFT JOIN users u ON c.instructor_id = u.id
                                    WHERE e.student_id = ? AND e.status = 'active'
                                    ORDER BY e.enrolled_date DESC");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEnrollment($course_id, $student_id) {
        $stmt = $this->db->prepare("SELECT * FROM enrollments WHERE course_id = ? AND student_id = ?");
        $stmt->execute([$course_id, $student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>