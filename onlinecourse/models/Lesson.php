<?php
class Lesson {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lấy danh sách bài học của một khóa học
    public function getByCourseId($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY `order_num` ASC, id ASC");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy một bài học
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM lessons WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo bài học mới
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO lessons 
            (course_id, title, content, video_url, `order_num`, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())");

        return $stmt->execute([
            $data['course_id'],
            $data['title'],
            $data['content'],
            $data['video_url'] ?? null,
            $data['order'] ?? 0
        ]);
    }

    // Cập nhật bài học
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE lessons SET 
            title = ?, content = ?, video_url = ?, `order_num` = ? 
            WHERE id = ?");

        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['video_url'] ?? null,
            $data['order'] ?? 0,
            $id
        ]);
    }

    // Xóa bài học
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM lessons WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>