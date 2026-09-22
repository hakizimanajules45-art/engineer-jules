<?php
/**
 * Service Model
 */

class ServiceModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM services ORDER BY sort_order ASC, id ASC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM services WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO services (title, description, icon, sort_order) VALUES (:title, :description, :icon, :sort_order)');
        $stmt->execute([
            'title'       => $data['title'],
            'description' => $data['description'],
            'icon'        => $data['icon'] ?? 'code',
            'sort_order'  => $data['sort_order'] ?? 0,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE services SET title = :title, description = :description, icon = :icon, sort_order = :sort_order WHERE id = :id');
        return $stmt->execute([
            'title'       => $data['title'],
            'description' => $data['description'],
            'icon'        => $data['icon'] ?? 'code',
            'sort_order'  => $data['sort_order'] ?? 0,
            'id'          => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM services WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM services')->fetchColumn();
    }
}
