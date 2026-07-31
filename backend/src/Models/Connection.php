<?php
namespace App\Models;

class Connection
{
    private $id;
    private $guest_id;
    private $connected_guest_id;
    private $connection_type;
    private $created_at;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->guest_id = $data['guest_id'] ?? null;
        $this->connected_guest_id = $data['connected_guest_id'] ?? null;
        $this->connection_type = $data['connection_type'] ?? 'group';
        $this->created_at = $data['created_at'] ?? null;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getGuestId() { return $this->guest_id; }
    public function getConnectedGuestId() { return $this->connected_guest_id; }
    public function getConnectionType() { return $this->connection_type; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setGuestId($guest_id) { $this->guest_id = $guest_id; }
    public function setConnectedGuestId($connected_guest_id) { $this->connected_guest_id = $connected_guest_id; }
    public function setConnectionType($connection_type) { $this->connection_type = $connection_type; }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'guest_id' => $this->guest_id,
            'connected_guest_id' => $this->connected_guest_id,
            'connection_type' => $this->connection_type,
            'created_at' => $this->created_at
        ];
    }
}
