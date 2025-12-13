<?php
class Material {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lấy tài liệu theo bài học
    public function getByLessonId($lesson_id) {
        $stmt = $this->db->prepare("SELECT * FROM materials WHERE lesson_id = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$lesson_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm tài liệu mới
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO materials 
            (lesson_id, filename, file_path, file_type, uploaded_at) 
            VALUES (?, ?, ?, ?, NOW())");

        return $stmt->execute([
            $data['lesson_id'],
            $data['filename'],
            $data['file_path'],
            $data['file_type']
        ]);
    }

    // Xóa tài liệu
    public function delete($id) {
        // Trước khi xóa DB, nên xóa file thực tế nữa (sẽ làm ở controller)
        $stmt = $this->db->prepare("DELETE FROM materials WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>