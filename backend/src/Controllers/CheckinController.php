<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\CheckinService;

class CheckinController
{
    private $checkinService;

    public function __construct(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }

    public function start(Request $request, Response $response, array $args): Response
    {
        try {
            $guestId = (int)$args['guestId'];
            $result = $this->checkinService->startCheckin($guestId);
            
            return $response->withJson([
                'status' => 'success',
                'message' => 'Checkin started, waiting for signature',
                'guest' => $result['guest']
            ]);
        } catch (\RuntimeException $e) {
            return $response->withJson(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function complete(Request $request, Response $response, array $args): Response
    {
        try {
            $guestId = (int)$args['guestId'];
            $data = $request->getParsedBody();
            $signatureData = $data['signature_data'] ?? null;
            
            $result = $this->checkinService->completeCheckin($guestId, $signatureData);
            
            return $response->withJson([
                'status' => 'success',
                'message' => 'Guest checked in successfully',
                'guest' => $result['guest']
            ]);
        } catch (\RuntimeException $e) {
            return $response->withJson(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function cancel(Request $request, Response $response, array $args): Response
    {
        try {
            $guestId = (int)$args['guestId'];
            $this->checkinService->cancelCheckin($guestId);
            
            return $response->withJson([
                'status' => 'success',
                'message' => 'Checkin cancelled'
            ]);
        } catch (\RuntimeException $e) {
            return $response->withJson(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }

    public function status(Request $request, Response $response, array $args): Response
    {
        try {
            $guestId = (int)$args['guestId'];
            $status = $this->checkinService->getCheckinStatus($guestId);
            
            return $response->withJson($status);
        } catch (\RuntimeException $e) {
            return $response->withJson(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $response->withJson(['error' => $e->getMessage()], 500);
        }
    }
}
