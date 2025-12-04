# Docker Setup dla aplikacji RCP Laravel

## 📋 Wymagania

- Docker Desktop (Windows/Mac) lub Docker Engine (Linux)
- Docker Compose

## 🚀 Szybki start

### 1. Przygotowanie pliku .env

Skopiuj plik `.env.example` do `.env`:

```bash
cp .env.example .env
```

### 2. Uruchomienie aplikacji

**Opcja A: Używając Docker Compose (zalecane)**

```bash
docker-compose up -d
```

**Opcja B: Używając samego Dockera**

```bash
# Zbuduj obraz
docker build -t rcp-app .

# Uruchom kontener
docker run -d -p 8080:80 --name rcp-app rcp-app
```

### 3. Dostęp do aplikacji

- **Aplikacja Laravel**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **MySQL**: localhost:3306

## 🔧 Konfiguracja

### Baza danych

Aplikacja domyślnie używa SQLite, ale możesz użyć MySQL:

1. W pliku `.env` zmień:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=rcp_database
DB_USERNAME=rcp_user
DB_PASSWORD=rcp_password
```

### Uruchomienie migracji

```bash
docker-compose exec app php artisan migrate
```

### Uruchomienie seederów

```bash
docker-compose exec app php artisan db:seed
```

## 📝 Przydatne komendy

### Zarządzanie kontenerami

```bash
# Uruchom kontenery
docker-compose up -d

# Zatrzymaj kontenery
docker-compose down

# Przebuduj kontenery
docker-compose up -d --build

# Zobacz logi
docker-compose logs -f

# Zobacz status
docker-compose ps
```

### Komendy Laravel w kontenerze

```bash
# Wejdź do kontenera
docker-compose exec app bash

# Uruchom artisan
docker-compose exec app php artisan [komenda]

# Composer
docker-compose exec app composer [komenda]

# NPM
docker-compose exec app npm [komenda]

# Czyszczenie cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan route:clear
```

### Migracje i seedowanie

```bash
# Migracje
docker-compose exec app php artisan migrate
docker-compose exec app php artisan migrate:fresh
docker-compose exec app php artisan migrate:fresh --seed

# Seedowanie
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan db:seed --class=UserSeeder
```

## 🐛 Rozwiązywanie problemów

### Problem z uprawnieniami

```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/storage
```

### Błąd "Class not found"

```bash
docker-compose exec app composer dump-autoload
```

### Błąd z kluczem aplikacji

```bash
docker-compose exec app php artisan key:generate
```

### Przebudowanie assetów

```bash
docker-compose exec app npm run build
```

## 🧪 Development vs Production

### Development

Dla developmentu zmień w `Dockerfile` linię:
```dockerfile
RUN composer install --optimize-autoloader --no-interaction
```

I w `.env`:
```env
APP_ENV=local
APP_DEBUG=true
```

### Production

W produkcji użyj:
```dockerfile
RUN composer install --no-dev --optimize-autoloader --no-interaction
```

I w `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

## 📦 Struktura plików Docker

```
docker/
├── apache/
│   └── 000-default.conf   # Konfiguracja Apache
├── start.sh               # Skrypt startowy
└── README.md             # Ta dokumentacja
Dockerfile                # Definicja obrazu Docker
docker-compose.yml        # Orkiestracja kontenerów
.dockerignore             # Pliki ignorowane przy budowaniu
```

## 🔒 Bezpieczeństwo

W produkcji pamiętaj o:
- Zmianie domyślnych haseł w `docker-compose.yml`
- Ustawieniu `APP_DEBUG=false`
- Użyciu silnych haseł dla bazy danych
- Ograniczeniu dostępu do portów (np. zamknięcie phpMyAdmin)

## 📚 Dodatkowe zasoby

- [Docker Documentation](https://docs.docker.com/)
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Deployment](https://laravel.com/docs/deployment)

