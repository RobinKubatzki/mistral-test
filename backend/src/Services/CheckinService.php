<?php
namespace App\Services;

use App\Repositories\GuestRepository;
use App\Models\Guest;

class CheckinService
{
    private $guestRepository;
    private $signatureStoragePath;

    public function __construct(GuestRepository $guestRepository, string $signatureStoragePath = null)
    {
        $this->guestRepository = $guestRepository;
        $this->signatureStoragePath = $signatureStoragePath ?? __DIR__ . '/../../storage/signatures';
        
        // Ensure storage directory exists
        if (!file_exists($this->signatureStoragePath)) {
            mkdir($this->signatureStoragePath, 0755, true);
        }
    }

    public function startCheckin(int $guestId): array
    {
        $guest = $this->guestRepository->find($guestId);
        
        if (!$guest) {
            throw new \RuntimeException('Guest not found');
        }
        
        if ($guest->isCheckedIn()) {
            throw new \RuntimeException('Guest is already checked in');
        }
        
        // Mark as in progress
        $this->guestRepository->update($guestId, ['checkin_in_progress' => true]);
        
        return [
            'guest' => $this->guestRepository->find($guestId)->toArray()
        ];
    }

    public function completeCheckin(int $guestId, ?string $signatureData): array
    {
        $guest = $this->guestRepository->find($guestId);
        
        if (!$guest) {
            throw new \RuntimeException('Guest not found');
        }
        
        if ($guest->isCheckedIn()) {
            throw new \RuntimeException('Guest is already checked in');
        }
        
        // Save signature
        $signatureId = null;
        if ($signatureData) {
            $signatureId = $this->saveSignature($guestId, $signatureData);
        }
        
        // Complete checkin
        $this->guestRepository->update($guestId, [
            'checked_in' => true,
            'checkin_date' => date('Y-m-d H:i:s'),
            'signature_id' => $signatureId,
            'checkin_in_progress' => false
        ]);
        
        return [
            'guest' => $this->guestRepository->find($guestId)->toArray()
        ];
    }

    public function cancelCheckin(int $guestId): void
    {
        $guest = $this->guestRepository->find($guestId);
        
        if (!$guest) {
            throw new \RuntimeException('Guest not found');
        }
        
        $this->guestRepository->update($guestId, [
            'checkin_in_progress' => false
        ]);
    }

    public function getCheckinStatus(int $guestId): array
    {
        $guest = $this->guestRepository->find($guestId);
        
        if (!$guest) {
            throw new \RuntimeException('Guest not found');
        }
        
        return [
            'checked_in' => $guest->isCheckedIn(),
            'checkin_in_progress' => false, // This would be tracked separately in a real app
            'checkin_date' => $guest->getCheckinDate()
        ];
    }

    private function saveSignature(int $guestId, string $base64Data): string
    {
        // Remove base64 prefix
        $base64Data = str_replace('data:image/png;base64,', '', $base64Data);
        $signatureData = base64_decode($base64Data);
        
        // Generate unique filename
        $signatureId = uniqid('sig_' . $guestId . '_', true);
        $filename = $this->signatureStoragePath . '/' . $signatureId . '.png';
        
        // Save file
        file_put_contents($filename, $signatureData);
        
        return $signatureId;
    }
}
