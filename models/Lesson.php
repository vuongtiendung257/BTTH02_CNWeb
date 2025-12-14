<?php
// models/Lesson.php
require_once 'config/Database.php';

class Lesson {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }
    
    /**
     * Lấy tổng số bài học trong một khóa học
     * @param int $course_id
     * @return int
     */
    public function countLessonsInCourse($course_id) {
        $query = "SELECT COUNT(id) FROM lessons WHERE course_id = :course_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /**
     * Lấy chi tiết bài học (để hiển thị nội dung)
     * @param int $lesson_id
     * @return array|null
     */
    public function getLessonDetail($lesson_id) {
        $query = "
            SELECT l.*, c.id AS course_id, c.title AS course_title
            FROM lessons l
            JOIN courses c ON l.course_id = c.id
            WHERE l.id = :lesson_id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lesson_id', $lesson_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy tài liệu của bài học
     * @param int $lesson_id
     * @return array
     */
    public function getMaterialsByLesson($lesson_id) {
        $query = "SELECT * FROM materials WHERE lesson_id = :lesson_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lesson_id', $lesson_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}