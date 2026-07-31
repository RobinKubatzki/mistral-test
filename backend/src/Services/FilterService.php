<?php
namespace App\Services;

use App\Repositories\GuestRepository;

class FilterService
{
    private $guestRepository;

    public function __construct(GuestRepository $guestRepository)
    {
        $this->guestRepository = $guestRepository;
    }

    public function applyFilters(array $filters): array
    {
        return $this->guestRepository->findByFilters($filters);
    }

    public function getFilterOptions(): array
    {
        $guests = $this->guestRepository->findAll();
        
        $categories = [];
        $arrivalDays = [];
        
        foreach ($guests as $guest) {
            $categories[$guest->getCategory()] = $guest->getCategory();
            $arrivalDays[$guest->getArrivalDay()] = $guest->getArrivalDay();
        }
        
        return [
            'categories' => array_values($categories),
            'arrival_days' => array_values($arrivalDays)
        ];
    }
}
