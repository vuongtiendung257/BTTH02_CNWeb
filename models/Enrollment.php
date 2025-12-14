<?php
// models/Enrollment.php

require_once 'config/Database.php';

class Enrollment {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    /**
     * Kiểm tra học viên đã đăng ký khóa học chưa
     * @param int $course_id
     * @param int $student_id
     * @return bool
     */
    public function isEnrolled($course_id, $student_id) {
        $query = "SELECT id FROM enrollments WHERE course_id = :course_id AND student_id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Đăng ký khóa học
     * @param int $course_id
     * @param int $student_id
     * @return bool
     */
    public function createEnrollment($course_id, $student_id) {
        $query = "INSERT INTO enrollments (course_id, student_id, status, progress) VALUES (:course_id, :student_id, 'active', 0)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Lấy danh sách khóa học đã đăng ký của học viên
     * @param int $student_id
     * @return array
     */
    public function getCoursesByStudent($student_id) {
        $query = "
            SELECT
                e.progress, c.id, c.title, c.image, c.price, c.duration_weeks, u.fullname AS instructor_name
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            JOIN users u ON c.instructor_id = u.id
            WHERE e.student_id = :student_id AND e.status = 'active'
            ORDER BY e.enrolled_date DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật tiến độ học tập
     * @param int $course_id
     * @param int $student_id
     * @param int $progress_percent
     * @return bool
     */
    public function updateProgress($course_id, $student_id, $progress_percent) {
        $query = "UPDATE enrollments SET progress = :progress_percent WHERE course_id = :course_id AND student_id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':progress_percent', $progress_percent, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getAllEnrolledCoursesWithProgress($studentId)
{
    $sql = "
        SELECT 
            c.id, c.title, c.price, c.duration_weeks,
            e.progress
        FROM enrollments e
        JOIN courses c ON e.course_id = c.id
        WHERE e.student_id = ?
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$studentId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}