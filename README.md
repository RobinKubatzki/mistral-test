# Checkin-Tool

A guest management system with Vue.js frontend, PHP backend, and MySQL database for efficient checkin processes.

## Features

- **Guest Management**: Add, edit, delete, and view guests
- **Filtering**: Filter guests by category, checkin status, arrival day, and search
- **Checkin Process**: Two-device workflow (PC for selection, tablet for signature)
- **Signature Collection**: Touch-friendly signature pad on tablets
- **Statistics**: Real-time statistics and analytics
- **Responsive Design**: Works on desktop and mobile devices

## Quick Start with Docker

### Prerequisites
- [Docker](https://www.docker.com/get-docker)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Installation

1. Clone the repository:
```bash
git clone https://github.com/RobinKubatzki/mistral-test.git
cd mistral-test
```

2. Start all services:
```bash
docker-compose -f docker/docker-compose.yml up -d
```

3. Wait for containers to initialize (about 30-60 seconds)

4. Access the application:
- **Frontend**: http://localhost:5173
- **Backend API**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080

### Network Access

To access the application from other devices on your local network:
1. Find your computer's local IP address
2. Use that IP instead of `localhost` (e.g., http://192.168.1.100:5173)

## Manual Installation

### Frontend

1. Navigate to frontend directory:
```bash
cd frontend
```

2. Install dependencies:
```bash
npm install
```

3. Start development server:
```bash
npm run dev
```

Access at: http://localhost:5173

### Backend

1. Navigate to backend directory:
```bash
cd backend
```

2. Install dependencies:
```bash
composer install
```

3. Start PHP server:
```bash
php -S localhost:8000 -t public
```

Access at: http://localhost:8000

### Database

1. Create database:
```bash
mysql -u root -p -e "CREATE DATABASE checkin_tool;"
```

2. Import schema:
```bash
mysql -u root -p checkin_tool < database/schema.sql
```

## Project Structure

See [PROJECT_STRUCTURE.md](PROJECT_STRUCTURE.md) for detailed project architecture and technology stack.

## Usage

### Adding a Guest
1. Click "Add Guest" button in the header
2. Fill in guest details (name, register ID, category, arrival day, etc.)
3. Click "Add Guest" to save

### Checking In a Guest
1. Select a guest from the list
2. Click "Start Checkin" button
3. On the tablet: Sign the signature pad
4. Click "Submit Signature" to complete checkin

### Viewing Statistics
1. Click "Statistics" button in the header
2. View overview and category breakdown

## API Endpoints

### Guests
- `GET /api/v1/guests` - List all guests
- `GET /api/v1/guests/{id}` - Get guest by ID
- `POST /api/v1/guests` - Create new guest
- `PUT /api/v1/guests/{id}` - Update guest
- `DELETE /api/v1/guests/{id}` - Delete guest

### Checkin
- `POST /api/v1/checkin/start/{guestId}` - Start checkin
- `POST /api/v1/checkin/complete/{guestId}` - Complete checkin with signature
- `POST /api/v1/checkin/cancel/{guestId}` - Cancel checkin
- `GET /api/v1/checkin/status/{guestId}` - Get checkin status

### Statistics
- `GET /api/v1/stats/summary` - Get summary statistics
- `GET /api/v1/stats/remaining` - Get remaining checkins

## Technology Stack

- **Frontend**: Vue.js 3, Vite, Pinia, Vue Router, Axios
- **Backend**: PHP 8.2, Slim Framework 4, PDO
- **Database**: MySQL 8.0
- **Containerization**: Docker, Docker Compose

## License

This project is proprietary. All rights reserved.
