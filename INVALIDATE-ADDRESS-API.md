# Invalidate Address API

API endpoint to flag invalid postal addresses across students, tutors and VIP addresses. Designed to be called by the envelope scanning tool after a mailing with returned letters.

## Setup

Add the following to your `.env` file:

```
INVALIDATE_ADDRESS_TOKEN=your-secret-token-here
```

The endpoint is only active when this env var is set. Without it, all requests return `401 Unauthorized`.

Run the migration:

```bash
php artisan migrate
```

This adds the `is_invalid_address` column to the `students`, `tutors` and `vip_addresses` tables.

## Endpoint

```
POST /api/invalidate-address
```

### Headers

| Header         | Value                  |
|----------------|------------------------|
| Content-Type   | application/json       |
| X-Api-Token    | your-secret-token-here |

### Request body

All fields are required and must match exactly.

```json
{
  "firstname": "Anna",
  "name": "Müller",
  "street": "Bahnhofstrasse",
  "street_no": "12",
  "zip": "8001",
  "city": "Zürich"
}
```

| Field      | Type   | Description    |
|------------|--------|----------------|
| firstname  | string | First name     |
| name       | string | Last name      |
| street     | string | Street name    |
| street_no  | string | Street number  |
| zip        | string | Postal code    |
| city       | string | City           |

### Response

```json
{
  "success": true,
  "total_matches": 1,
  "matches": {
    "students": [
      {
        "id": "uuid-here",
        "name": "Müller",
        "firstname": "Anna"
      }
    ],
    "tutors": [],
    "vip": []
  }
}
```

### Error responses

| Status | Reason                                      |
|--------|---------------------------------------------|
| 401    | Missing or invalid `X-Api-Token` header     |
| 422    | Missing or invalid request body fields      |

## Example

```bash
curl -X POST https://sipt.ch/api/invalidate-address \
  -H "Content-Type: application/json" \
  -H "X-Api-Token: your-secret-token-here" \
  -d '{
    "firstname": "Anna",
    "name": "Müller",
    "street": "Bahnhofstrasse",
    "street_no": "12",
    "zip": "8001",
    "city": "Zürich"
  }'
```

## Address exports

The flag appears as "Adresse ungültig" column (`1` or `0`) in the Excel exports for students, tutors and VIP addresses.
