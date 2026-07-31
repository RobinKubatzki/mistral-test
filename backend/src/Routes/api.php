<?php
use App\Controllers\GuestController;
use App\Controllers\CheckinController;
use App\Controllers\StatsController;
use App\Services\GuestService;
use App\Services\CheckinService;
use App\Repositories\GuestRepository;

// Get PDO from container
$pdo = $app->getContainer()->get('db');

// Create repositories
$guestRepository = new GuestRepository($pdo);

// Create services
$guestService = new GuestService($guestRepository);
$checkinService = new CheckinService($guestRepository);

// Create controllers
$guestController = new GuestController($guestService);
$checkinController = new CheckinController($checkinService);
$statsController = new StatsController($guestService);

// Guest routes
$app->get('/api/v1/guests', [$guestController, 'index']);
$app->get('/api/v1/guests/{id}', [$guestController, 'show']);
$app->get('/api/v1/guests/register/{registerId}', [$guestController, 'showByRegisterId']);
$app->post('/api/v1/guests', [$guestController, 'store']);
$app->put('/api/v1/guests/{id}', [$guestController, 'update']);
$app->delete('/api/v1/guests/{id}', [$guestController, 'destroy']);

// Checkin routes
$app->post('/api/v1/checkin/start/{guestId}', [$checkinController, 'start']);
$app->post('/api/v1/checkin/complete/{guestId}', [$checkinController, 'complete']);
$app->post('/api/v1/checkin/cancel/{guestId}', [$checkinController, 'cancel']);
$app->get('/api/v1/checkin/status/{guestId}', [$checkinController, 'status']);

// Stats routes
$app->get('/api/v1/stats/summary', [$statsController, 'summary']);
$app->get('/api/v1/stats/remaining', [$statsController, 'remaining']);
