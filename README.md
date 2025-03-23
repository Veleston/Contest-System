# Contest Participation System API

A RESTful API for managing contests, participations, Leaderboard and prizes.

## Features

* User authentication and authorization
* Contest creation and management
* Participation tracking
* Prize distribution
* Rate limiting
* Role-based access control

## Endpoints

### Authentication

| Method | Endpoint | Description | Role Required |
| --- | --- | --- | --- |
| POST | `/register` | Create new user | None |
| POST | `/login` | Login user | None |
| POST | `/logout` | Logout user | Authenticated |

### Contests

| Method | Endpoint | Description | Role Required |
| --- | --- | --- | --- |
| GET | `/contests` | List contests | Authenticated |
| POST | `/contests` | Create contest | Authenticated |
| GET | `/contests/{id}` | View contest | Authenticated |
| PUT | `/contests/{id}` | Update contest | Authenticated |
| DELETE | `/contests/{id}` | Delete contest | Authenticated |

### Participations

| Method | Endpoint | Description | Role Required |
| --- | --- | --- | --- |
| POST | `/contests/{id}/participate` | Participate in contest | Authenticated |
| POST | `/participations/{id}/submit` | Submit answers | Authenticated |
| GET | `/participations/{id}` | View participation | Authenticated |

### Leaderboard

| Method | Endpoint | Description | Role Required |
| --- | --- | --- | --- |
| GET | `/contests/{id}/leaderboard` | View leaderboard | Authenticated |

### Prizes

| Method | Endpoint | Description | Role Required |
| --- | --- | --- | --- |
| GET | `/prizes` | List prizes | Authenticated |
| GET | `/prizes/{id}` | View prize | Authenticated |

## Rate Limiting

| Endpoint Group | Limit |
| --- | --- |
| Auth | 5 requests/minute |
| Contests | 60 requests/minute |
| Participations | 30 requests/minute |
| Leaderboard | 100 requests/minute |
| Prizes | 100 requests/minute |

## Roles

* VIP: Full access to all contests
* SIGNED_IN: Access to normal contests only
* GUEST: View-only access

## API Response Format

```json
{
    "data": {
        // Resource data
    },
    "message": "Success message",
    "status": 200
}
```

## Error Response Format

```json
{
    "error": "Error message",
    "status": 400
}
```

## Getting Started

1. Clone the repository
2. Install dependencies: `composer install`
3. Run migrations: `php artisan migrate`
4. Start the server: `php artisan serve`
5. Use the API endpoints as documented above