<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\GuestService;

class StatsController
{
    private $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    public function summary(Request $request, Response $response): Response
    {
        try {
            $stats = $this->guestService->getStats();
            
            return $response->withJson($stats);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function remaining(Request $request, Response $response): Response
    {
        try {
            $stats = $this->guestService->getStats();
            
            return $response->withJson([
                'remaining' => $stats['pending'],
                'total' => $stats['total']
            ]);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }
}
