# API Obecności Pracowników

Dokumentacja endpointów API do zarządzania danymi o obecnościach pracowników.

## Base URL

```
/api/work-sessions
```

## Endpointy

### 1. Pobierz obecności dla konkretnego dnia

**Endpoint:** `GET /api/work-sessions/by-date`

**Parametry (query string):**
- `date` (wymagany) - Data w formacie `YYYY-MM-DD`
- `personel_id` (opcjonalny) - ID pracownika do filtrowania
- `status_id` (opcjonalny) - ID statusu do filtrowania

**Przykładowe zapytania:**

```bash
# Wszystkie obecności dla dnia 2025-11-29
GET /api/work-sessions/by-date?date=2025-11-29

# Obecności konkretnego pracownika
GET /api/work-sessions/by-date?date=2025-11-29&personel_id=5

# Obecności z konkretnym statusem
GET /api/work-sessions/by-date?date=2025-11-29&status_id=1

# Kombinacja filtrów
GET /api/work-sessions/by-date?date=2025-11-29&personel_id=5&status_id=1
```

**Przykładowa odpowiedź:**

```json
{
  "data": [
    {
      "id": 1,
      "work_date": "2025-11-29",
      "start_time": "08:00:00",
      "end_time": "16:30:00",
      "duration": 510,
      "adjusted_duration": 495,
      "duration_human": "8h 15min",
      "notes": "Praca w dziale IT",
      "has_overtime": true,
      "incomplete_shift_warning": null,
      "display_status": "Obecny (zakończył pracę)",
      "personel": {
        "id": 5,
        "personal_number": "12345",
        "first_name": "Jan",
        "last_name": "Kowalski",
        "full_name": "Jan Kowalski",
        "email": "jan.kowalski@example.com",
        "is_active": true,
        "position": {
          "id": 2,
          "name": "Programista"
        },
        "work_place": {
          "id": 1,
          "name": "Oddział Główny"
        }
      },
      "status": {
        "id": 1,
        "name": "Obecny"
      },
      "created_at": "2025-11-29T08:00:00+01:00",
      "updated_at": "2025-11-29T16:30:00+01:00"
    }
  ]
}
```

---

### 2. Pobierz obecności dla zakresu dat

**Endpoint:** `GET /api/work-sessions/by-date-range`

**Parametry (query string):**
- `date_from` (wymagany) - Data początkowa w formacie `YYYY-MM-DD`
- `date_to` (wymagany) - Data końcowa w formacie `YYYY-MM-DD`
- `personel_id` (opcjonalny) - ID pracownika do filtrowania
- `status_id` (opcjonalny) - ID statusu do filtrowania

**Przykładowe zapytania:**

```bash
# Wszystkie obecności z zakresu dat
GET /api/work-sessions/by-date-range?date_from=2025-11-01&date_to=2025-11-30

# Obecności konkretnego pracownika z zakresu
GET /api/work-sessions/by-date-range?date_from=2025-11-01&date_to=2025-11-30&personel_id=5
```

**Odpowiedź:** Taka sama struktura jak w endpoint `/by-date`

---

### 3. Pobierz szczegóły pojedynczej sesji

**Endpoint:** `GET /api/work-sessions/{workSession}`

**Parametry (URL):**
- `workSession` (wymagany) - ID sesji pracy

**Przykładowe zapytanie:**

```bash
GET /api/work-sessions/1
```

**Przykładowa odpowiedź:**

```json
{
  "data": {
    "id": 1,
    "work_date": "2025-11-29",
    "start_time": "08:00:00",
    "end_time": "16:30:00",
    "duration": 510,
    "adjusted_duration": 495,
    "duration_human": "8h 15min",
    "notes": "Praca w dziale IT",
    "has_overtime": true,
    "incomplete_shift_warning": null,
    "display_status": "Obecny (zakończył pracę)",
    "personel": {
      "id": 5,
      "personal_number": "12345",
      "first_name": "Jan",
      "last_name": "Kowalski",
      "full_name": "Jan Kowalski",
      "email": "jan.kowalski@example.com",
      "is_active": true,
      "position": {
        "id": 2,
        "name": "Programista"
      },
      "work_place": {
        "id": 1,
        "name": "Oddział Główny"
      }
    },
    "status": {
      "id": 1,
      "name": "Obecny"
    },
    "created_at": "2025-11-29T08:00:00+01:00",
    "updated_at": "2025-11-29T16:30:00+01:00"
  }
}
```

---

### 4. Pobierz statystyki obecności dla dnia

**Endpoint:** `GET /api/work-sessions/statistics`

**Parametry (query string):**
- `date` (wymagany) - Data w formacie `YYYY-MM-DD`

**Przykładowe zapytanie:**

```bash
GET /api/work-sessions/statistics?date=2025-11-29
```

**Przykładowa odpowiedź:**

```json
{
  "date": "2025-11-29",
  "statistics": {
    "total_employees": 25,
    "total_work_hours": 202.5,
    "total_work_minutes": 12150,
    "employees_with_overtime": 5,
    "incomplete_shifts": 2,
    "average_work_hours_per_employee": 8.1
  }
}
```

---

## Kody błędów

### 422 Unprocessable Entity

Zwracany gdy walidacja parametrów się nie powiedzie.

**Przykład:**

```json
{
  "message": "Błąd walidacji",
  "errors": {
    "date": [
      "Data jest wymagana"
    ]
  }
}
```

### 404 Not Found

Zwracany gdy zasób (np. sesja pracy) nie został znaleziony.

---

## Notatki implementacyjne

### Adjusted Duration

API zwraca zarówno `duration` (faktyczny czas pracy w minutach) jak i `adjusted_duration` (czas po zaokrągleniu nadgodzin).

Reguła zaokrąglenia:
- Dla czasu pracy ≤ 8h: zwracany jest faktyczny czas
- Dla czasu pracy > 8h: nadgodziny są zaokrąglane w dół do pełnych 15 minut

### Format dat

Wszystkie daty i czasy są zwracane w formacie ISO 8601 z informacją o strefie czasowej.

### Eager Loading

API automatycznie ładuje powiązane dane (personel, pozycja, miejsce pracy, status) aby zminimalizować liczbę zapytań do bazy danych.

---

## Przykłady użycia

### JavaScript (Fetch API)

```javascript
// Pobierz obecności dla konkretnego dnia
fetch('/api/work-sessions/by-date?date=2025-11-29')
  .then(response => response.json())
  .then(data => {
    console.log('Obecności:', data.data);
  });

// Pobierz statystyki
fetch('/api/work-sessions/statistics?date=2025-11-29')
  .then(response => response.json())
  .then(data => {
    console.log('Statystyki:', data.statistics);
  });
```

### cURL

```bash
# Pobierz obecności
curl -X GET "http://localhost/api/work-sessions/by-date?date=2025-11-29" \
  -H "Accept: application/json"

# Pobierz statystyki
curl -X GET "http://localhost/api/work-sessions/statistics?date=2025-11-29" \
  -H "Accept: application/json"
```

### PHP (Guzzle)

```php
use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://localhost']);

// Pobierz obecności
$response = $client->get('/api/work-sessions/by-date', [
    'query' => ['date' => '2025-11-29']
]);

$workSessions = json_decode($response->getBody(), true);
```

