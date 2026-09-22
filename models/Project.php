<?php
/**
 * Project Model
 */

class Project
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM projects ORDER BY sort_order ASC, id DESC');
        return $stmt->fetchAll();
    }

    public function featured(int $limit = 3): array
    {
        $stmt = $this->db->prepare('SELECT * FROM projects WHERE featured = 1 ORDER BY sort_order ASC, id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM projects WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO projects
                (title, slug, short_description, description, features, technologies, github_link, live_demo, image, gallery, featured, sort_order)
                VALUES
                (:title, :slug, :short_description, :description, :features, :technologies, :github_link, :live_demo, :image, :gallery, :featured, :sort_order)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title'             => $data['title'],
            'slug'              => $data['slug'],
            'short_description' => $data['short_description'],
            'description'       => $data['description'],
            'features'          => $data['features'],
            'technologies'      => $data['technologies'],
            'github_link'       => $data['github_link'],
            'live_demo'         => $data['live_demo'],
            'image'             => $data['image'],
            'gallery'           => $data['gallery'] ?? '',
            'featured'          => $data['featured'] ?? 0,
            'sort_order'        => $data['sort_order'] ?? 0,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE projects SET
                    title = :title,
                    slug = :slug,
                    short_description = :short_description,
                    description = :description,
                    features = :features,
                    technologies = :technologies,
                    github_link = :github_link,
                    live_demo = :live_demo,
                    image = :image,
                    gallery = :gallery,
                    featured = :featured,
                    sort_order = :sort_order
                WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title'             => $data['title'],
            'slug'              => $data['slug'],
            'short_description' => $data['short_description'],
            'description'       => $data['description'],
            'features'          => $data['features'],
            'technologies'      => $data['technologies'],
            'github_link'       => $data['github_link'],
            'live_demo'         => $data['live_demo'],
            'image'             => $data['image'],
            'gallery'           => $data['gallery'] ?? '',
            'featured'          => $data['featured'] ?? 0,
            'sort_order'        => $data['sort_order'] ?? 0,
            'id'                => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM projects WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM projects')->fetchColumn();
    }
}
