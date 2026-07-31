# Checkin-Tool Project Structure & Technology Stack

## Overview

This document describes the architecture, directory structure, and technology stack for the Checkin-Tool application - a guest management system with Vue.js frontend, PHP backend, and MySQL database.

---

## Project Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        Checkin-Tool Application                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌─────────────────┐    ┌─────────────────┐    ┌─────────────┐  │
│  │   Vue.js         │    │    PHP          │    │   MySQL     │  │
│  │   Frontend       │◄──►│    Backend      │◄──►│   Database  │  │
│  │   (Port: 5173)   │    │   (Port: 8000)  │    │   (Port: 3306)│  │
│  └─────────────────┘    └─────────────────┘    └─────────────┘  │
│                                                                     │
│  ┌─────────────────────────────────────────────────────────────┐│
│  │                    Device Pair Communication                    ││
│  │  ┌─────────────┐          ┌─────────────┐                     ││
│  │  │    PC       │          │   Tablet    │                     ││
│  │  │ (Guest      │◄────────►│ (Signature  │                     ││
│  │  │  Selection) │  WebSocket  │  Collection)│                     ││
│  │  └─────────────┘          └─────────────┘                     ││
│  └─────────────────────────────────────────────────────────────┘│
│                                                                     │
└─────────────────────────────────────────────────────────────────┘
```

---

## Directory Structure

```
checkin-tool/
├── frontend/                          # Vue.js Application
│   ├── public/                        # Static files
│   │   ├── index.html                 # Main HTML template
│   │   └── favicon.ico                # Favicon
│   │
│   ├── src/                           # Source files
│   │   ├── assets/                    # Assets (CSS, images)
│   │   │   └── styles/                # Global styles
│   │   │       ├── main.scss          # Main SCSS file
│   │   │       └── variables.scss     # SCSS variables
│   │   │
│   │   ├── components/                # Vue components
│   │   │   ├── common/                # Reusable components
│   │   │   │   ├── Modal.vue          # Modal component
│   │   │   │   └── LoadingSpinner.vue # Loading indicator
│   │   │   │
│   │   │   ├── layout/                # Layout components
│   │   │   │   ├── Header.vue         # Application header
│   │   │   │   └── Sidebar.vue        # Sidebar navigation
│   │   │   │
│   │   │   ├── guests/                # Guest-related components
│   │   │   │   ├── GuestList.vue      # Guest list with filtering
│   │   │   │   ├── GuestCard.vue      # Individual guest card
│   │   │   │   ├── GuestDetails.vue   # Guest details panel
│   │   │   │   ├── GuestForm.vue      # Add/edit guest form
│   │   │   │   └── GuestFilter.vue    # Filter builder component
│   │   │   │
│   │   │   ├── checkout/              # Checkin components
│   │   │   │   ├── CheckinModal.vue   # Checkin confirmation modal
│   │   │   │   └── SignaturePad.vue   # Signature collection component
│   │   │   │
│   │   │   └── statistics/            # Statistics components
│   │   │       ├── StatsModal.vue     # Statistics modal
│   │   │       └── StatsSummary.vue   # Summary statistics
│   │   │
│   │   ├── composables/               # Vue 3 composables
│   │   │   ├── useGuests.js           # Guest data management
│   │   │   ├── useFilter.js           # Filter logic
│   │   │   ├── useCheckin.js          # Checkin functionality
│   │   │   └── useApi.js              # API communication
│   │   │
│   │   ├── stores/                    # Pinia stores (state management)
│   │   │   ├── guestStore.js          # Guest state
│   │   │   ├── filterStore.js         # Filter state
│   │   │   └── uiStore.js             # UI state (modals, loading, etc.)
│   │   │
│   │   ├── router/                    # Vue Router
│   │   │   └── index.js               # Route definitions
│   │   │
│   │   ├── views/                     # Page views
│   │   │   ├── HomeView.vue           # Main dashboard
│   │   │   └── GuestsView.vue         # Guest management page
│   │   │
│   │   ├── App.vue                    # Root component
│   │   └── main.js                    # Application entry point
│   │
│   ├── .env                           # Environment variables
│   ├── package.json                   # NPM dependencies and scripts
│   └── vite.config.js                 # Vite configuration
│
├── backend/                           # PHP Backend
│   ├── public/                        # Publicly accessible files
│   │   └── index.php                  # Front controller
│   │
│   ├── src/                           # Source files
│   │   ├── Controllers/               # Controller classes
│   │   │   ├── GuestController.php    # Guest management
│   │   │   ├── CheckinController.php  # Checkin operations
│   │   │   └── StatsController.php    # Statistics operations
│   │   │
│   │   ├── Models/                    # Data models
│   │   │   ├── Guest.php              # Guest model
│   │   │   └── Connection.php          # Guest connection model
│   │   │
│   │   ├── Services/                  # Business logic services
│   │   │   ├── GuestService.php       # Guest business logic
│   │   │   ├── CheckinService.php     # Checkin business logic
│   │   │   └── FilterService.php      # Filter processing
│   │   │
│   │   ├── Repositories/              # Data access layer
│   │   │   └── GuestRepository.php    # Guest database operations
│   │   │
│   │   ├── Routes/                    # Route definitions
│   │   │   └── api.php                # API routes
│   │   │
│   │   ├── Config/                    # Configuration files
│   │   │   └── database.php           # Database configuration
│   │   │
│   │   └── bootstrap.php              # Application bootstrap
│   │
│   ├── vendor/                        # Composer dependencies
│   ├── .env                           # Environment variables
│   ├── composer.json                  # Composer dependencies
│   └── composer.lock                  # Composer lock file
│
├── database/                         # Database files
│   ├── migrations/                    # Database migrations
│   │   ├── 2024_01_01_create_guests_table.php
│   │   └── 2024_01_02_create_connections_table.php
│   │
│   └── schema.sql                     # Complete database schema
│
├── docker/                           # Docker configuration
│   ├── docker-compose.yml             # Docker Compose configuration
│   ├── nginx/                         # Nginx configuration
│   │   ├── Dockerfile                 # Nginx Dockerfile
│   │   └── conf.d/                    # Nginx config files
│   │       └── app.conf               # Application config
│   ├── php/                          # PHP configuration
│   │   └── Dockerfile                 # PHP Dockerfile
│   └── mysql/                         # MySQL configuration
│       ├── Dockerfile                 # MySQL Dockerfile
│       └── init.sql                   # Initial database setup
│
├── .gitignore                        # Git ignore rules
├── README.md                         # Project README
└── PROJECT_STRUCTURE.md              # This file
```

---

## Technology Stack

### Frontend

| Technology | Version | Purpose | Documentation |
|------------|---------|---------|---------------|
| [Vue.js](https://vuejs.org/) | 3.x | Progressive JavaScript Framework | [Docs](https://vuejs.org/guide/) |
| [Vite](https://vitejs.dev/) | 5.x | Build tool and dev server | [Docs](https://vitejs.dev/guide/) |
| [Pinia](https://pinia.vuejs.org/) | 2.x | State management | [Docs](https://pinia.vuejs.org/) |
| [Vue Router](https://router.vuejs.org/) | 4.x | Client-side routing | [Docs](https://router.vuejs.org/) |
| [Axios](https://axios-http.com/) | 1.x | HTTP client | [Docs](https://axios-http.com/docs/intro) |
| [Sass/SCSS](https://sass-lang.com/) | Latest | CSS preprocessor | [Docs](https://sass-lang.com/documentation/) |

### Backend

| Technology | Version | Purpose | Documentation |
|------------|---------|---------|---------------|
| [PHP](https://www.php.net/) | 8.2+ | Server-side scripting | [Docs](https://www.php.net/docs.php) |
| [Slim Framework](https://www.slimframework.com/) | 4.x | Micro framework | [Docs](https://www.slimframework.com/docs/v4/) |
| [PDO](https://www.php.net/manual/en/book.pdo.php) | Built-in | Database access | [Docs](https://www.php.net/manual/en/book.pdo.php) |
| [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) | 5.x | Environment variables | [Docs](https://github.com/vlucas/phpdotenv) |

### Database

| Technology | Version | Purpose | Documentation |
|------------|---------|---------|---------------|
| [MySQL](https://www.mysql.com/) | 8.0+ | Relational database | [Docs](https://dev.mysql.com/doc/) |

### Development Tools

| Tool | Version | Purpose | Documentation |
|------|---------|---------|---------------|
| [Node.js](https://nodejs.org/) | 20.x | JavaScript runtime | [Docs](https://nodejs.org/en/docs) |
| [NPM](https://www.npmjs.com/) | 10.x | Package manager | [Docs](https://docs.npmjs.com/) |
| [Composer](https://getcomposer.org/) | 2.x | PHP dependency manager | [Docs](https://getcomposer.org/doc/) |
| [Docker](https://www.docker.com/) | 24.x | Containerization | [Docs](https://docs.docker.com/) |
| [Docker Compose](https://docs.docker.com/compose/) | 2.x | Multi-container orchestration | [Docs](https://docs.docker.com/compose/) |
| [Git](https://git-scm.com/) | 2.x | Version control | [Docs](https://git-scm.com/doc) |

---

## Database Schema

### Tables

#### 1. `guests`

```sql
CREATE TABLE `guests` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `register_id` VARCHAR(50) UNIQUE NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `age` INT,
  `category` ENUM('standard', 'vip', 'family', 'group', 'other') DEFAULT 'standard',
  `arrival_day` DATE NOT NULL,
  `checked_in` BOOLEAN DEFAULT FALSE,
  `checkin_date` DATETIME NULL,
  `note` TEXT,
  `signature_id` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### 2. `connections`

```sql
CREATE TABLE `connections` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `guest_id` INT NOT NULL,
  `connected_guest_id` INT NOT NULL,
  `connection_type` ENUM('family', 'friend', 'colleague', 'group', 'other') DEFAULT 'group',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE,
  FOREIGN KEY (connected_guest_id) REFERENCES guests(id) ON DELETE CASCADE,
  
  UNIQUE KEY unique_connection (guest_id, connected_guest_id)
);
```

---

## API Endpoints

### Base URL
```
http://localhost:8000/api/v1
```

### Guest Endpoints

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| GET | `/guests` | Get all guests with optional filtering | `category`, `checked_in`, `arrival_day`, `search` |
| GET | `/guests/{id}` | Get a single guest by ID | - |
| GET | `/guests/register/{registerId}` | Get a guest by register ID | - |
| POST | `/guests` | Create a new guest | Guest data in request body |
| PUT | `/guests/{id}` | Update a guest | Guest data in request body |
| DELETE | `/guests/{id}` | Delete a guest | - |

### Checkin Endpoints

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| POST | `/checkin/start/{guestId}` | Start checkin process for a guest | - |
| POST | `/checkin/complete/{guestId}` | Complete checkin with signature | `signature_data` (base64) |
| POST | `/checkin/cancel/{guestId}` | Cancel checkin process | - |
| GET | `/checkin/status/{guestId}` | Get checkin status | - |

### Connection Endpoints

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| GET | `/guests/{id}/connections` | Get connections for a guest | - |
| POST | `/guests/{id}/connections` | Add a connection | `connected_guest_id`, `connection_type` |
| DELETE | `/guests/{id}/connections/{connectionId}` | Remove a connection | - |

### Statistics Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/stats/summary` | Get summary statistics |
| GET | `/stats/remaining` | Get count of guests not checked in |

---

## Signature Collection Process

The signature collection is designed to work with **two paired devices**: a PC for guest selection and a tablet for signature capture. This allows for a smooth checkin experience where guests can sign on a touch-friendly device.

### Overview Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                    Signature Collection Flow                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌─────────────────┐         ┌─────────────────┐                 │
│  │      PC          │         │     Tablet       │                 │
│  │ (Guest Selection)│         │ (Signature Pad)  │                 │
│  └─────────┬────────┘         └─────────┬────────┘                 │
│            │                           │                       │
│            │  1. Select Guest           │                       │
│            │──────────────────────────►│  2. Show Guest Info    │
│            │                           │                       │
│            │  3. Request Signature      │                       │
│            │──────────────────────────►│  4. Display Canvas     │
│            │                           │                       │
│            │  5. Wait for Signature     │                       │
│            │◄──────────────────────────│  6. User Signs         │
│            │                           │                       │
│            │  7. Receive Signature Data │                       │
│            │◄──────────────────────────│  8. Send Signature     │
│            │                           │                       │
│            │  9. Save to Database       │                       │
│            │──────────────────────────►│  10. Clear Canvas      │
│            │                           │                       │
│            │  11. Confirm Checkin       │                       │
│            └───────────────────────────┴───────────────────────┘ │
│                                                                     │
└─────────────────────────────────────────────────────────────────┘
```

### Step-by-Step Process

#### 1. Device Pairing (Optional but Recommended)

Before signature collection, devices can be paired to ensure secure communication:

- **PC** generates a unique pairing code (e.g., `ABC-123`)
- **Tablet** connects to the same backend and enters the pairing code
- Backend confirms the pairing and establishes a WebSocket connection
- Both devices are now linked for the checkin session

#### 2. Guest Selection (PC)

- User selects a guest from the guest list on the PC
- PC sends request to backend: `POST /api/v1/checkin/start/{guestId}`
- Backend retrieves guest details and marks guest as "checkin in progress"
- Backend notifies all paired tablets via WebSocket with event `checkin:start`

#### 3. Guest Display (Tablet)

- Tablet receives guest information via WebSocket
- Tablet displays:
  - Guest full name
  - Guest category
  - Arrival day
  - Any special notes
  - Signature canvas area with instructions

#### 4. Signature Capture (Tablet)

The tablet uses an **HTML5 Canvas element** with touch support for signature collection:

**Canvas Setup:**
```html
<canvas 
  id="signaturePad" 
  width="800" 
  height="400"
  style="border: 1px solid #ccc; background: white; touch-action: none;"
></canvas>
```

**Key Features:**
- Touch-optimized for tablets and mobile devices
- Works with both finger and stylus input
- Smooth drawing with anti-aliasing
- Real-time preview as user draws

**JavaScript Implementation:**
```javascript
// Vue.js composable for signature pad
import { ref, onMounted } from 'vue'

export function useSignaturePad() {
  const canvas = ref(null)
  const context = ref(null)
  const isDrawing = ref(false)
  const signatureData = ref(null)
  const lastX = ref(0)
  const lastY = ref(0)

  // Initialize canvas
  function initCanvas() {
    if (!canvas.value) return
    
    context.value = canvas.value.getContext('2d')
    context.value.strokeStyle = '#000000'
    context.value.lineWidth = 3
    context.value.lineCap = 'round'
    context.value.lineJoin = 'round'
    
    // Clear canvas
    clearCanvas()
  }

  // Clear the canvas
  function clearCanvas() {
    if (context.value) {
      context.value.clearRect(0, 0, canvas.value.width, canvas.value.height)
    }
    signatureData.value = null
  }

  // Start drawing
  function startDrawing(e) {
    isDrawing.value = true
    const pos = getPosition(e)
    lastX.value = pos.x
    lastY.value = pos.y
  }

  // Draw on canvas
  function draw(e) {
    if (!isDrawing.value) return
    
    const pos = getPosition(e)
    
    context.value.beginPath()
    context.value.moveTo(lastX.value, lastY.value)
    context.value.lineTo(pos.x, pos.y)
    context.value.stroke()
    
    lastX.value = pos.x
    lastY.value = pos.y
  }

  // End drawing
  function endDrawing() {
    isDrawing.value = false
    
    // Save signature as base64
    if (canvas.value) {
      signatureData.value = canvas.value.toDataURL('image/png')
    }
  }

  // Get position from touch or mouse event
  function getPosition(e) {
    const rect = canvas.value.getBoundingClientRect()
    const clientX = e.clientX || (e.touches && e.touches[0].clientX)
    const clientY = e.clientY || (e.touches && e.touches[0].clientY)
    
    return {
      x: clientX - rect.left,
      y: clientY - rect.top
    }
  }

  onMounted(() => {
    initCanvas()
  })

  return {
    canvas,
    clearCanvas,
    startDrawing,
    draw,
    endDrawing,
    signatureData
  }
}
```

#### 5. Signature Submission (Tablet)

When the guest is satisfied with their signature:

- User taps "Submit" button on the tablet
- Tablet sends signature data to backend: `POST /api/v1/checkin/complete/{guestId}`
- Request body contains:
  ```json
  {
    "signature_data": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...",
    "device_id": "tablet-001"
  }
  ```

#### 6. Backend Processing

Backend receives the signature and:

1. Validates the guest ID and checkin status
2. Generates a unique signature ID (UUID)
3. Saves the signature (either to database or filesystem)
4. Updates guest record:
   ```sql
   UPDATE guests 
   SET 
     checked_in = TRUE,
     checkin_date = NOW(),
     signature_id = 'uuid-generated-id'
   WHERE id = {guestId}
   ```
5. Sends confirmation to both PC and tablet via WebSocket with event `checkin:complete`

#### 7. Checkin Confirmation (Both Devices)

- **PC**: Shows checkmark next to guest, updates guest list, removes "waiting" status
- **Tablet**: Shows success message, clears canvas for next guest, plays confirmation sound
- Both devices receive real-time updates via WebSocket

### Frontend Components

**SignaturePad.vue (Tablet):**
```vue
<template>
  <div class="signature-container">
    <!-- Guest Information -->
    <div class="guest-info">
      <h2>{{ guest.full_name }}</h2>
      <p>Category: {{ guest.category }}</p>
      <p>Arrival: {{ formatDate(guest.arrival_day) }}</p>
      <p v-if="guest.note" class="note">Note: {{ guest.note }}</p>
    </div>
    
    <!-- Signature Canvas -->
    <div class="canvas-wrapper">
      <canvas 
        ref="canvas" 
        @touchstart="startDrawing" 
        @touchmove="draw" 
        @touchend="endDrawing"
        @mousedown="startDrawing" 
        @mousemove="draw" 
        @mouseup="endDrawing"
        @mouseleave="endDrawing"
      ></canvas>
      <p class="instruction">Please sign above</p>
    </div>
    
    <!-- Controls -->
    <div class="signature-controls">
      <button @click="clearCanvas" class="btn-secondary">
        <i class="icon-undo"></i> Clear
      </button>
      <button @click="submitSignature" 
              :disabled="!hasSignature" 
              class="btn-primary">
        <i class="icon-check"></i> Submit Signature
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useSignaturePad } from '../composables/useSignaturePad'
import { useCheckin } from '../composables/useCheckin'

const props = defineProps({
  guest: Object
})

const {
  canvas,
  clearCanvas,
  startDrawing,
  draw,
  endDrawing,
  signatureData
} = useSignaturePad()

const { completeCheckin } = useCheckin()

const hasSignature = computed(() => signatureData.value !== null)

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString()
}

async function submitSignature() {
  if (!hasSignature.value) return
  
  try {
    await completeCheckin(props.guest.id, signatureData.value)
    // Show success message
    alert('Signature submitted successfully!')
    clearCanvas()
  } catch (error) {
    alert('Error submitting signature: ' + error.message)
  }
}
</script>

<style scoped>
.signature-container {
  display: flex;
  flex-direction: column;
  height: 100vh;
  padding: 20px;
  box-sizing: border-box;
}

.guest-info {
  margin-bottom: 20px;
  padding: 15px;
  background: #f5f5f5;
  border-radius: 8px;
}

.canvas-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin: 20px 0;
}

canvas {
  border: 2px solid #333;
  background: white;
  width: 100%;
  max-width: 800px;
  height: 400px;
  touch-action: none;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.instruction {
  margin-top: 10px;
  color: #666;
  font-size: 16px;
}

.signature-controls {
  display: flex;
  gap: 15px;
  justify-content: center;
  margin-top: 20px;
}

button {
  padding: 12px 24px;
  font-size: 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
}

button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
```

**CheckinStatus.vue (PC):**
```vue
<template>
  <div class="checkin-status">
    <span v-if="!guest.checked_in && !guest.checkin_in_progress">
      <button @click="startCheckin(guest.id)" class="btn-start">
        Start Checkin
      </button>
    </span>
    <span v-if="guest.checkin_in_progress" class="status waiting">
      <i class="icon-clock"></i> Waiting for signature...
    </span>
    <span v-if="guest.checked_in" class="status completed">
      <i class="icon-check"></i> Checked In
    </span>
  </div>
</template>

<script setup>
import { useCheckin } from '../composables/useCheckin'

const props = defineProps({
  guest: Object
})

const { startCheckin } = useCheckin()
</script>

<style scoped>
.checkin-status {
  display: flex;
  align-items: center;
  gap: 10px;
}

.btn-start {
  padding: 8px 16px;
  background: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.status {
  padding: 8px 12px;
  border-radius: 4px;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.status.waiting {
  background: #FFF3CD;
  color: #856404;
}

.status.completed {
  background: #D4EDDA;
  color: #155724;
}
</style>
```

### Backend Implementation

**CheckinController.php:**
```php
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
    
    /**
     * Start checkin process for a guest
     */
    public function startCheckin(Request $request, Response $response, array $args): Response
    {
        $guestId = $args['guestId'];
        
        try {
            $result = $this->checkinService->startCheckin($guestId);
            
            return $response->withJson([
                'status' => 'success',
                'message' => 'Checkin started, waiting for signature',
                'guest' => $result['guest']
            ], 200);
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Complete checkin with signature
     */
    public function completeCheckin(Request $request, Response $response, array $args): Response
    {
        $guestId = $args['guestId'];
        $data = $request->getParsedBody();
        
        try {
            $result = $this->checkinService->completeCheckin(
                $guestId,
                $data['signature_data'] ?? null
            );
            
            return $response->withJson([
                'status' => 'success',
                'message' => 'Guest checked in successfully',
                'guest' => $result['guest']
            ], 200);
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Cancel checkin process
     */
    public function cancelCheckin(Request $request, Response $response, array $args): Response
    {
        $guestId = $args['guestId'];
        
        try {
            $this->checkinService->cancelCheckin($guestId);
            
            return $response->withJson([
                'status' => 'success',
                'message' => 'Checkin cancelled'
            ], 200);
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
```

**CheckinService.php:**
```php
<?php
namespace App\Services;

use App\Repositories\GuestRepository;
use App\Models\Guest;

class CheckinService
{
    private $guestRepository;
    
    public function __construct(GuestRepository $guestRepository)
    {
        $this->guestRepository = $guestRepository;
    }
    
    /**
     * Start checkin process
     */
    public function startCheckin(int $guestId): array
    {
        // Find guest
        $guest = $this->guestRepository->find($guestId);
        
        if (!$guest) {
            throw new \Exception('Guest not found');
        }
        
        if ($guest->checked_in) {
            throw new \Exception('Guest is already checked in');
        }
        
        if ($guest->checkin_in_progress) {
            throw new \Exception('Checkin already in progress for this guest');
        }
        
        // Mark as in progress
        $this->guestRepository->update($guestId, [
            'checkin_in_progress' => true
        ]);
        
        // Broadcast to tablets
        $this->broadcastCheckinStart($guest);
        
        return [
            'guest' => $guest
        ];
    }
    
    /**
     * Complete checkin with signature
     */
    public function completeCheckin(int $guestId, ?string $signatureData): array
    {
        $guest = $this->guestRepository->find($guestId);
        
        if (!$guest) {
            throw new \Exception('Guest not found');
        }
        
        if (!$guest->checkin_in_progress) {
            throw new \Exception('Checkin not in progress');
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
        
        // Broadcast completion
        $this->broadcastCheckinComplete($guestId);
        
        // Return updated guest
        $updatedGuest = $this->guestRepository->find($guestId);
        
        return [
            'guest' => $updatedGuest
        ];
    }
    
    /**
     * Save signature to filesystem
     */
    private function saveSignature(int $guestId, string $base64Data): string
    {
        $signatureDir = __DIR__ . '/../../storage/signatures/';
        
        if (!file_exists($signatureDir)) {
            mkdir($signatureDir, 0755, true);
        }
        
        // Remove base64 prefix
        $base64Data = str_replace('data:image/png;base64,', '', $base64Data);
        $signatureData = base64_decode($base64Data);
        
        // Generate unique filename
        $signatureId = uniqid('sig_' . $guestId . '_', true);
        $filename = $signatureDir . $signatureId . '.png';
        
        // Save file
        file_put_contents($filename, $signatureData);
        
        return $signatureId;
    }
    
    /**
     * Cancel checkin
     */
    public function cancelCheckin(int $guestId): void
    {
        $guest = $this->guestRepository->find($guestId);
        
        if (!$guest) {
            throw new \Exception('Guest not found');
        }
        
        $this->guestRepository->update($guestId, [
            'checkin_in_progress' => false
        ]);
        
        $this->broadcastCheckinCancel($guestId);
    }
    
    /**
     * Broadcast checkin start to tablets
     */
    private function broadcastCheckinStart(Guest $guest): void
    {
        // Implementation depends on your WebSocket server
        // This would send a WebSocket message to all connected tablets
    }
    
    /**
     * Broadcast checkin completion
     */
    private function broadcastCheckinComplete(int $guestId): void
    {
        // Implementation depends on your WebSocket server
    }
    
    /**
     * Broadcast checkin cancellation
     */
    private function broadcastCheckinCancel(int $guestId): void
    {
        // Implementation depends on your WebSocket server
    }
}
```

### WebSocket Communication

**Events:**

| Event | Direction | Data | Description |
|-------|-----------|------|-------------|
| `checkin:start` | Backend → Tablet | `{guest_id, guest}` | Notify tablet to show guest and canvas |
| `checkin:complete` | Backend → All | `{guest_id}` | Notify all devices that checkin is complete |
| `checkin:cancel` | Backend → Tablet | `{guest_id}` | Notify tablet to clear canvas |
| `signature:submit` | Tablet → Backend | `{guest_id, signature_data}` | Submit signature to backend |

**WebSocket Client (Frontend):**
```javascript
// composables/useWebSocket.js
import { ref, onMounted, onUnmounted } from 'vue'

export function useWebSocket(url) {
  const socket = ref(null)
  const isConnected = ref(false)
  const error = ref(null)

  function connect() {
    try {
      socket.value = new WebSocket(url)
      
      socket.value.onopen = () => {
        isConnected.value = true
        console.log('WebSocket connected')
      }
      
      socket.value.onclose = () => {
        isConnected.value = false
        console.log('WebSocket disconnected')
      }
      
      socket.value.onerror = (e) => {
        error.value = e
        console.error('WebSocket error:', e)
      }
    } catch (e) {
      error.value = e
    }
  }

  function send(message) {
    if (socket.value && isConnected.value) {
      socket.value.send(JSON.stringify(message))
    }
  }

  function onMessage(callback) {
    if (socket.value) {
      socket.value.onmessage = (event) => {
        const data = JSON.parse(event.data)
        callback(data)
      }
    }
  }

  function disconnect() {
    if (socket.value) {
      socket.value.close()
    }
  }

  onMounted(() => {
    connect()
  })

  onUnmounted(() => {
    disconnect()
  })

  return {
    socket,
    isConnected,
    error,
    send,
    onMessage,
    disconnect,
    connect
  }
}
```

### Signature Storage Options

#### Option 1: File System Storage (Recommended)

Save signature images to the filesystem:

```php
// In your backend configuration
define('SIGNATURE_STORAGE_PATH', __DIR__ . '/../storage/signatures/');

// Ensure directory exists
if (!file_exists(SIGNATURE_STORAGE_PATH)) {
    mkdir(SIGNATURE_STORAGE_PATH, 0755, true);
}
```

**Pros:**
- Better performance
- Smaller database size
- Easy to backup and manage

**Cons:**
- Need to manage file storage
- Need to handle file cleanup

#### Option 2: Database Storage

Store the base64 encoded image directly in the database:

```sql
ALTER TABLE guests ADD COLUMN signature_data LONGTEXT;
```

**Pros:**
- Simple implementation
- No file management needed
- Easy to backup with database

**Cons:**
- Database can grow large with many signatures
- Slower queries

### User Experience Considerations

1. **Tablet Display:**
   - Use large, touch-friendly buttons (minimum 48x48px)
   - Ensure canvas takes up most of the screen
   - Disable browser zoom/gestures that might interfere with drawing
   - Use portrait orientation for better signature experience

2. **Signature Quality:**
   - Use black pen on white background for best readability
   - Allow pen thickness adjustment (2-4px recommended)
   - Smooth the drawing line for better appearance
   - Consider adding a signature preview before final submission

3. **Accessibility:**
   - Provide alternative for guests who cannot sign (e.g., "I cannot sign" button)
   - Allow typing name instead of signature
   - Ensure sufficient contrast for visibility
   - Add haptic feedback on successful submission

4. **Multi-device Support:**
   - Support both landscape and portrait orientations
   - Work on various tablet sizes (7" to 12")
   - Handle device rotation gracefully
   - Test on iOS and Android tablets

5. **Error Handling:**
   - Show clear error messages if signature submission fails
   - Allow retry without losing the signature
   - Provide visual feedback during loading states

---

## Docker Setup

### Prerequisites

- [Docker](https://www.docker.com/get-docker) installed
- [Docker Compose](https://docs.docker.com/compose/install/) installed
- Your router allows local network access to Docker containers (most do by default)

### Quick Start

```bash
# Clone the repository
git clone https://github.com/RobinKubatzki/mistral-test.git
cd mistral-test

# Start all services with Docker Compose
docker-compose -f docker/docker-compose.yml up -d

# Wait for containers to initialize (about 30-60 seconds)
# Then access the application from any device on your network
```

### Accessing the Application on Your Network

Once Docker Compose is running, you can access the application from **any device on your local network**:

| Service | Local Access | Network Access |
|---------|--------------|----------------|
| Frontend (Vue.js) | http://localhost:5173 | http://[YOUR_LOCAL_IP]:5173 |
| Backend API (PHP) | http://localhost:8000 | http://[YOUR_LOCAL_IP]:8000 |
| phpMyAdmin | http://localhost:8080 | http://[YOUR_LOCAL_IP]:8080 |

**To find your local IP address:**

- **Windows**: Run `ipconfig` in Command Prompt and look for "IPv4 Address"
- **Mac/Linux**: Run `ifconfig` or `ip a` in Terminal and look for your network interface

**Example**: If your computer's local IP is `192.168.1.100`, then:
- Frontend: http://192.168.1.100:5173
- Backend API: http://192.168.1.100:8000
- phpMyAdmin: http://192.168.1.100:8080

### Docker Compose Configuration

The `docker/docker-compose.yml` file sets up:

```yaml
version: '3.8'

services:
  # Nginx reverse proxy for frontend
  frontend:
    build: ./docker/nginx
    ports:
      - "5173:80"
    volumes:
      - ./frontend:/var/www/html
    depends_on:
      - backend
    networks:
      - checkin-network

  # PHP backend
  backend:
    build: ./docker/php
    ports:
      - "8000:8000"
    volumes:
      - ./backend:/var/www/html
    environment:
      - DB_HOST=mysql
      - DB_DATABASE=checkin_tool
      - DB_USERNAME=checkin_user
      - DB_PASSWORD=checkin_password
    depends_on:
      - mysql
    networks:
      - checkin-network

  # MySQL database
  mysql:
    build: ./docker/mysql
    ports:
      - "3306:3306"
    environment:
      - MYSQL_ROOT_PASSWORD=root_password
      - MYSQL_DATABASE=checkin_tool
      - MYSQL_USER=checkin_user
      - MYSQL_PASSWORD=checkin_password
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - checkin-network

  # phpMyAdmin for database management
  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    ports:
      - "8080:80"
    environment:
      - PMA_HOST=mysql
      - PMA_PORT=3306
    depends_on:
      - mysql
    networks:
      - checkin-network

volumes:
  mysql_data:

networks:
  checkin-network:
    driver: bridge
```

### Docker Commands

```bash
# Start all services
docker-compose -f docker/docker-compose.yml up -d

# Stop all services
docker-compose -f docker/docker-compose.yml down

# Stop and remove containers, networks, and volumes
docker-compose -f docker/docker-compose.yml down -v

# View logs
docker-compose -f docker/docker-compose.yml logs -f

# View running containers
docker-compose -f docker/docker-compose.yml ps

# Restart services
docker-compose -f docker/docker-compose.yml restart
```

### Environment Variables for Docker

The Docker setup uses the following default credentials:

- **MySQL**: Host: `mysql`, Database: `checkin_tool`, User: `checkin_user`, Password: `checkin_password`
- **phpMyAdmin**: Accessible at port 8080, connects to MySQL service

---

## Manual Development Setup (Alternative)

If you prefer not to use Docker, you can set up the application manually:

### Prerequisites

- Node.js 20.x
- PHP 8.2+
- MySQL 8.0+
- Composer 2.x

### Frontend

```bash
cd frontend
npm install
npm run dev
```

Access at: http://localhost:5173

### Backend

```bash
cd backend
composer install
php -S localhost:8000 -t public
```

Access at: http://localhost:8000

### Database

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE checkin_tool;"

# Import schema
mysql -u root -p checkin_tool < database/schema.sql
```

---

## Project Conventions

### File Naming

- **Components**: PascalCase (e.g., `GuestList.vue`)
- **Composables**: camelCase with `use` prefix (e.g., `useGuests.js`)
- **Stores**: camelCase with `Store` suffix (e.g., `guestStore.js`)
- **Controllers**: PascalCase with `Controller` suffix (e.g., `GuestController.php`)
- **Models**: PascalCase (e.g., `Guest.php`)
- **Services**: PascalCase with `Service` suffix (e.g., `GuestService.php`)

### Branch Naming

- `main` - Production ready code
- `feature/*` - New features
- `fix/*` - Bug fixes

---

## Network Access Notes

### Firewall Considerations

If you have a firewall enabled, you may need to allow the Docker ports:

```bash
# On Linux (ufw)
sudo ufw allow 5173/tcp
sudo ufw allow 8000/tcp
sudo ufw allow 8080/tcp
sudo ufw allow 3306/tcp

# On Windows/macOS
# Check your firewall settings to allow incoming connections on these ports
```

### Router Configuration

Most modern routers automatically allow local network traffic. However, if you have issues:

1. Ensure all devices are on the **same local network**
2. Check that your router doesn't have **AP Isolation** enabled (this prevents devices from seeing each other)
3. Verify that your computer's firewall allows incoming connections on the Docker ports

### Testing Network Access

From another device on your network, try:

```bash
# Test if the frontend is accessible
curl http://[YOUR_LOCAL_IP]:5173

# Test if the backend API is accessible
curl http://[YOUR_LOCAL_IP]:8000/api/v1/guests
```

---

## License

This project is proprietary. All rights reserved.

---

*Document version: 1.0.0*
