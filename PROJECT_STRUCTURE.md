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

Stores all guest information with the following fields:
- `id` - Auto-incrementing primary key
- `register_id` - Unique identifier for the guest
- `full_name` - Guest's full name
- `age` - Guest's age
- `category` - Guest category (standard, vip, family, group, other)
- `arrival_day` - Date of arrival
- `checked_in` - Boolean indicating if guest has checked in
- `checkin_date` - Timestamp when guest checked in
- `note` - Additional notes about the guest
- `signature_id` - Reference to the signature file
- `created_at` - When the guest was created
- `updated_at` - When the guest was last updated

#### 2. `connections`

Stores relationships between guests:
- `id` - Auto-incrementing primary key
- `guest_id` - First guest in the connection
- `connected_guest_id` - Second guest in the connection
- `connection_type` - Type of connection (family, friend, colleague, group, other)
- `created_at` - When the connection was created

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
- PC sends request to backend to start checkin for the selected guest
- Backend retrieves guest details and marks guest as "checkin in progress"
- Backend notifies all paired tablets via WebSocket

#### 3. Guest Display (Tablet)

- Tablet receives guest information via WebSocket
- Tablet displays:
  - Guest full name
  - Guest category
  - Arrival day
  - Any special notes
  - Signature canvas area with instructions

#### 4. Signature Capture (Tablet)

The tablet uses an HTML5 Canvas element with touch support for signature collection:

**Key Features:**
- Touch-optimized for tablets and mobile devices
- Works with both finger and stylus input
- Smooth drawing with anti-aliasing
- Real-time preview as user draws
- Undo/Redo functionality
- Clear canvas button

#### 5. Signature Submission (Tablet)

When the guest is satisfied with their signature:

- User taps "Submit" button on the tablet
- Tablet sends signature data (as base64 encoded PNG image) to backend
- Request includes the guest ID and the signature image data

#### 6. Backend Processing

Backend receives the signature and:

1. Validates the guest ID and checkin status
2. Generates a unique signature ID (UUID)
3. Saves the signature to the filesystem
4. Updates guest record in the database with:
   - `checked_in = TRUE`
   - `checkin_date = current timestamp`
   - `signature_id = generated UUID`
   - `checkin_in_progress = FALSE`
5. Sends confirmation to both PC and tablet via WebSocket

#### 7. Checkin Confirmation (Both Devices)

- **PC**: Shows checkmark next to guest, updates guest list, removes "waiting" status
- **Tablet**: Shows success message, clears canvas for next guest
- Both devices receive real-time updates via WebSocket

### WebSocket Communication

**Events:**

| Event | Direction | Data | Description |
|-------|-----------|------|-------------|
| `checkin:start` | Backend → Tablet | `{guest_id, guest}` | Notify tablet to show guest and canvas |
| `checkin:complete` | Backend → All | `{guest_id}` | Notify all devices that checkin is complete |
| `checkin:cancel` | Backend → Tablet | `{guest_id}` | Notify tablet to clear canvas |

### Signature Storage

Signatures are stored as PNG images in the filesystem under a dedicated directory. Each signature file is named with a unique identifier that is stored in the guest's `signature_id` field.

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

3. **Accessibility:**
   - Provide alternative for guests who cannot sign (e.g., "I cannot sign" button)
   - Allow typing name instead of signature
   - Ensure sufficient contrast for visibility

4. **Multi-device Support:**
   - Support both landscape and portrait orientations
   - Work on various tablet sizes (7" to 12")
   - Handle device rotation gracefully

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

- **Frontend**: Nginx serving the Vue.js application on port 5173
- **Backend**: PHP application on port 8000
- **Database**: MySQL database on port 3306
- **phpMyAdmin**: Database management interface on port 8080

All services are connected via a shared Docker network called `checkin-network`.

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
