<?php
namespace App\Services;

use App\Repositories\GuestRepository;
use App\Models\Guest;

class GuestService
{
    private $guestRepository;

    public function __construct(GuestRepository $guestRepository)
    {
        $this->guestRepository = $guestRepository;
    }

    public function getAllGuests(): array
    {
        return $this->guestRepository->findAll();
    }

    public function getGuestById(int $id): ?Guest
    {
        return $this->guestRepository->find($id);
    }

    public function getGuestByRegisterId(string $registerId): ?Guest
    {
        return $this->guestRepository->findByRegisterId($registerId);
    }

    public function createGuest(array $data): Guest
    {
        // Validate required fields
        if (empty($data['full_name'])) {
            throw new \InvalidArgumentException('Full name is required');
        }
        
        if (empty($data['arrival_day'])) {
            throw new \InvalidArgumentException('Arrival day is required');
        }
        
        // Generate register_id if not provided
        if (empty($data['register_id'])) {
            $data['register_id'] = uniqid('guest_', true);
        }
        
        return $this->guestRepository->create($data);
    }

    public function updateGuest(int $id, array $data): ?Guest
    {
        $guest = $this->getGuestById($id);
        if (!$guest) {
            throw new \RuntimeException('Guest not found');
        }
        
        return $this->guestRepository->update($id, $data);
    }

    public function deleteGuest(int $id): bool
    {
        $guest = $this->getGuestById($id);
        if (!$guest) {
            throw new \RuntimeException('Guest not found');
        }
        
        return $this->guestRepository->delete($id);
    }

    public function getGuestsByFilters(array $filters): array
    {
        return $this->guestRepository->findByFilters($filters);
    }

    public function getStats(): array
    {
        return $this->guestRepository->getStats();
    }
}
