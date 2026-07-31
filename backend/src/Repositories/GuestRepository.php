<?php
namespace App\Repositories;

use PDO;
use App\Models\Guest;

class GuestRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM guests ORDER BY arrival_day, full_name");
        $guests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map(function ($data) {
            return new Guest($data);
        }, $guests);
    }

    public function find(int $id): ?Guest
    {
        $stmt = $this->pdo->prepare("SELECT * FROM guests WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? new Guest($data) : null;
    }

    public function findByRegisterId(string $registerId): ?Guest
    {
        $stmt = $this->pdo->prepare("SELECT * FROM guests WHERE register_id = ?");
        $stmt->execute([$registerId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? new Guest($data) : null;
    }

    public function create(array $data): Guest
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO guests (register_id, full_name, age, category, arrival_day, note, signature_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $data['register_id'] ?? uniqid('guest_'),
            $data['full_name'],
            $data['age'] ?? null,
            $data['category'] ?? 'standard',
            $data['arrival_day'],
            $data['note'] ?? null,
            $data['signature_id'] ?? null
        ]);
        
        $id = $this->pdo->lastInsertId();
        return $this->find($id);
    }

    public function update(int $id, array $data): ?Guest
    {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if ($key !== 'id' && $key !== 'created_at') {
                $fields[] = "$key = ?";
                $values[] = $value;
            }
        }
        
        if (empty($fields)) {
            return $this->find($id);
        }
        
        $values[] = $id;
        $values[] = date('Y-m-d H:i:s');
        
        $sql = "UPDATE guests SET " . implode(', ', $fields) . ", updated_at = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        
        return $this->find($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM guests WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findByFilters(array $filters): array
    {
        $where = [];
        $params = [];
        
        if (!empty($filters['category'])) {
            $where[] = "category = ?";
            $params[] = $filters['category'];
        }
        
        if (isset($filters['checked_in'])) {
            $where[] = "checked_in = ?";
            $params[] = filter_var($filters['checked_in'], FILTER_VALIDATE_BOOLEAN);
        }
        
        if (!empty($filters['arrival_day'])) {
            $where[] = "arrival_day = ?";
            $params[] = $filters['arrival_day'];
        }
        
        if (!empty($filters['search'])) {
            $where[] = "full_name LIKE ?";
            $params[] = "%" . $filters['search'] . "%";
        }
        
        $sql = "SELECT * FROM guests";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        $sql .= " ORDER BY arrival_day, full_name";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $guests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map(function ($data) {
            return new Guest($data);
        }, $guests);
    }

    public function getStats(): array
    {
        $total = $this->count();
        $checkedIn = $this->countByStatus(true);
        $pending = $total - $checkedIn;
        
        return [
            'total' => $total,
            'checked_in' => $checkedIn,
            'pending' => $pending,
            'by_category' => $this->countByCategory()
        ];
    }

    private function count(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM guests");
        return (int)$stmt->fetchColumn();
    }

    private function countByStatus(bool $status): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM guests WHERE checked_in = ?");
        $stmt->execute([$status ? 1 : 0]);
        return (int)$stmt->fetchColumn();
    }

    private function countByCategory(): array
    {
        $stmt = $this->pdo->query("SELECT category, COUNT(*) as count FROM guests GROUP BY category");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $counts = [];
        foreach ($results as $row) {
            $counts[$row['category']] = (int)$row['count'];
        }
        
        return $counts;
    }
}
