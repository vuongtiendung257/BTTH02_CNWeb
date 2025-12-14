<?php
// models/Course.php

require_once 'config/Database.php';

class Course {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    /**
     * Lấy tất cả khóa học (có tìm kiếm và lọc)
     * @param string|null $search
     * @param int|null $category_id
     * @return array
     */
    public function getAllCourses($search = null, $category_id = null) {
        $query = "
            SELECT
                c.*, u.fullname AS instructor_name, cat.name AS category_name
            FROM courses c
            JOIN users u ON c.instructor_id = u.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE c.status = 'approved'
        ";

        $conditions = [];
        $params = [];

        if ($search) {
            $conditions[] = "c.title LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        if ($category_id && $category_id > 0) {
            $conditions[] = "c.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }

        if (count($conditions) > 0) {
            $query .= " AND " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy chi tiết khóa học
     * @param int $id
     * @return array|null
     */
    public function getCourseDetail($id) {
        $query = "
            SELECT
                c.*, u.fullname AS instructor_name, cat.name AS category_name, u.email AS instructor_email
            FROM courses c
            JOIN users u ON c.instructor_id = u.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE c.id = :id AND c.status = 'approved'
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy danh sách bài học thuộc khóa học
     * @param int $course_id
     * @return array
     */
    public function getLessonsByCourse($course_id) {
        $query = "SELECT id, title, order_num FROM lessons WHERE course_id = :course_id ORDER BY order_num ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}