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
