<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\GuestService;

class GuestController
{
    private $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    public function index(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        
        // Extract filters
        $filters = [];
        if (!empty($queryParams['category'])) {
            $filters['category'] = $queryParams['category'];
        }
        if (isset($queryParams['checked_in'])) {
            $filters['checked_in'] = $queryParams['checked_in'];
        }
        if (!empty($queryParams['arrival_day'])) {
            $filters['arrival_day'] = $queryParams['arrival_day'];
        }
        if (!empty($queryParams['search'])) {
            $filters['search'] = $queryParams['search'];
        }
        
        try {
            if (!empty($filters)) {
                $guests = $this->guestService->getGuestsByFilters($filters);
            } else {
                $guests = $this->guestService->getAllGuests();
            }
            
            $guestArray = array_map(function ($guest) {
                return $guest->toArray();
            }, $guests);
            
            return $response->withJson($guestArray);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        try {
            $guest = $this->guestService->getGuestById((int)$args['id']);
            
            if (!$guest) {
                return $response->withJson(['error' => 'Guest not found'], 404);
            }
            
            return $response->withJson($guest->toArray());
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function showByRegisterId(Request $request, Response $response, array $args): Response
    {
        try {
            $guest = $this->guestService->getGuestByRegisterId($args['registerId']);
            
            if (!$guest) {
                return $response->withJson(['error' => 'Guest not found'], 404);
            }
            
            return $response->withJson($guest->toArray());
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            $guest = $this->guestService->createGuest($data);
            
            return $response->withJson($guest->toArray(), 201);
        } catch (\InvalidArgumentException $e) {
            return $response->withJson(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        try {
            $id = (int)$args['id'];
            $data = $request->getParsedBody();
            $guest = $this->guestService->updateGuest($id, $data);
            
            if (!$guest) {
                return $response->withJson(['error' => 'Guest not found'], 404);
            }
            
            return $response->withJson($guest->toArray());
        } catch (\RuntimeException $e) {
            return $response->withJson(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        try {
            $id = (int)$args['id'];
            $success = $this->guestService->deleteGuest($id);
            
            if (!$success) {
                return $response->withJson(['error' => 'Guest not found'], 404);
            }
            
            return $response->withJson(['message' => 'Guest deleted successfully']);
        } catch (\RuntimeException $e) {
            return $response->withJson(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }
}
