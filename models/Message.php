<?php
/**
 * Contact Message Model
 */

class Message
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM messages ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM messages WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO messages (name, email, project_type, message) VALUES (:name, :email, :project_type, :message)');
        $stmt->execute([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'project_type' => $data['project_type'],
            'message'      => $data['message'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function markRead(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE messages SET is_read = 1 WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM messages WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM messages')->fetchColumn();
    }

    public function unreadCount(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
    }
}
