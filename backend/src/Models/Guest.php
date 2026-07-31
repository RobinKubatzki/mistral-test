<?php
namespace App\Models;

class Guest
{
    private $id;
    private $register_id;
    private $full_name;
    private $age;
    private $category;
    private $arrival_day;
    private $checked_in;
    private $checkin_date;
    private $note;
    private $signature_id;
    private $created_at;
    private $updated_at;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->register_id = $data['register_id'] ?? '';
        $this->full_name = $data['full_name'] ?? '';
        $this->age = $data['age'] ?? null;
        $this->category = $data['category'] ?? 'standard';
        $this->arrival_day = $data['arrival_day'] ?? null;
        $this->checked_in = $data['checked_in'] ?? false;
        $this->checkin_date = $data['checkin_date'] ?? null;
        $this->note = $data['note'] ?? null;
        $this->signature_id = $data['signature_id'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getRegisterId() { return $this->register_id; }
    public function getFullName() { return $this->full_name; }
    public function getAge() { return $this->age; }
    public function getCategory() { return $this->category; }
    public function getArrivalDay() { return $this->arrival_day; }
    public function isCheckedIn() { return $this->checked_in; }
    public function getCheckinDate() { return $this->checkin_date; }
    public function getNote() { return $this->note; }
    public function getSignatureId() { return $this->signature_id; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setRegisterId($register_id) { $this->register_id = $register_id; }
    public function setFullName($full_name) { $this->full_name = $full_name; }
    public function setAge($age) { $this->age = $age; }
    public function setCategory($category) { $this->category = $category; }
    public function setArrivalDay($arrival_day) { $this->arrival_day = $arrival_day; }
    public function setCheckedIn($checked_in) { $this->checked_in = $checked_in; }
    public function setCheckinDate($checkin_date) { $this->checkin_date = $checkin_date; }
    public function setNote($note) { $this->note = $note; }
    public function setSignatureId($signature_id) { $this->signature_id = $signature_id; }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'register_id' => $this->register_id,
            'full_name' => $this->full_name,
            'age' => $this->age,
            'category' => $this->category,
            'arrival_day' => $this->arrival_day,
            'checked_in' => $this->checked_in,
            'checkin_date' => $this->checkin_date,
            'note' => $this->note,
            'signature_id' => $this->signature_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
