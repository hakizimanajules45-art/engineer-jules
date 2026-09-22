<?php
/**
 * Site Settings Model
 */

class Settings
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function get(): array
    {
        $stmt = $this->db->query('SELECT * FROM settings ORDER BY id ASC LIMIT 1');
        $row = $stmt->fetch();
        return $row ?: [];
    }

    public function update(array $data): bool
    {
        $existing = $this->get();

        if (!$existing) {
            $stmt = $this->db->prepare('INSERT INTO settings (site_name, tagline, hero_title, hero_subtitle, email, whatsapp, github, whatsapp_message)
                VALUES (:site_name, :tagline, :hero_title, :hero_subtitle, :email, :whatsapp, :github, :whatsapp_message)');
        } else {
            $stmt = $this->db->prepare('UPDATE settings SET
                site_name = :site_name,
                tagline = :tagline,
                hero_title = :hero_title,
                hero_subtitle = :hero_subtitle,
                email = :email,
                whatsapp = :whatsapp,
                github = :github,
                whatsapp_message = :whatsapp_message
                WHERE id = :id');
            $data['id'] = $existing['id'];
        }

        $params = [
            'site_name'        => $data['site_name'],
            'tagline'          => $data['tagline'],
            'hero_title'       => $data['hero_title'],
            'hero_subtitle'    => $data['hero_subtitle'],
            'email'            => $data['email'],
            'whatsapp'         => $data['whatsapp'],
            'github'           => $data['github'],
            'whatsapp_message' => $data['whatsapp_message'],
        ];

        if (isset($data['id'])) {
            $params['id'] = $data['id'];
        }

        return $stmt->execute($params);
    }
}
