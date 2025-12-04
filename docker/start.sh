#!/bin/bash

# Skrypt startowy dla kontenera Laravel

echo "🚀 Uruchamianie aplikacji Laravel..."

# Generuj certyfikat SSL jeśli nie istnieje
CERT_DIR="/etc/ssl/private"
KEY_FILE="$CERT_DIR/selfsigned.key"
CERT_FILE="$CERT_DIR/selfsigned.crt"

if [ ! -f "$CERT_FILE" ]; then
    echo "🔒 Generowanie certyfikatu SSL..."
    mkdir -p "$CERT_DIR"
    # Generuj certyfikat z SAN (Subject Alternative Names) dla domeny
    openssl req -x509 -nodes -days 3650 -newkey rsa:4096 \
        -keyout "$KEY_FILE" -out "$CERT_FILE" \
        -subj "/C=PL/ST=Lodzkie/L=Lodz/O=WBG/CN=rcp.wbg.lodzkie.pl" \
        -addext "subjectAltName=DNS:rcp.wbg.lodzkie.pl,DNS:*.wbg.lodzkie.pl" 2>/dev/null
    echo "✅ Certyfikat SSL wygenerowany dla rcp.wbg.lodzkie.pl"
else
    echo "🔒 Certyfikat SSL już istnieje"
fi

# Sprawdź czy istnieje plik .env
if [ ! -f .env ]; then
    echo "⚠️  Plik .env nie istnieje. Kopiuję z .env.example..."
    cp .env.example .env
fi

# Generuj klucz aplikacji jeśli nie istnieje
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generuję klucz aplikacji..."
    php artisan key:generate
fi

# Upewnij się, że katalog storage i bootstrap/cache mają odpowiednie uprawnienia
echo "🔧 Ustawianie uprawnień..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Czekaj aż MySQL będzie gotowy
echo "⏳ Oczekiwanie na gotowość MySQL..."
MAX_RETRIES=30
RETRY_COUNT=0
DB_HOST="${DB_HOST:-mysql}"
DB_PORT="${DB_PORT:-3306}"

while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
    if php -r "
    try {
        \$pdo = new PDO('mysql:host=$DB_HOST;port=$DB_PORT', '${DB_USERNAME:-rcp_user}', '${DB_PASSWORD:-rcp_password}');
        \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'OK';
        exit(0);
    } catch (Exception \$e) {
        exit(1);
    }
    " 2>/dev/null | grep -q "OK"; then
        echo "✅ MySQL jest gotowy!"
        break
    fi
    
    RETRY_COUNT=$((RETRY_COUNT + 1))
    if [ $RETRY_COUNT -lt $MAX_RETRIES ]; then
        echo "   Próba $RETRY_COUNT/$MAX_RETRIES - czekam 2 sekundy..."
        sleep 2
    else
        echo "⚠️  MySQL nie odpowiada po $MAX_RETRIES próbach. Kontynuuję mimo to..."
    fi
done

# Uruchom migracje (opcjonalnie - odkomentuj jeśli chcesz automatyczne migracje)
echo "🗄️  Uruchamianie migracji..."
php artisan migrate --force

# Uruchom seedery (opcjonalnie - odkomentuj jeśli chcesz automatyczne seedowanie)
# echo "🌱 Seedowanie bazy danych..."
# php artisan db:seed --force || echo "⚠️  Seedowanie nie powiodło się (może baza już zawiera dane)"

# Czyść cache
echo "🧹 Czyszczenie cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache konfiguracji dla lepszej wydajności
echo "⚡ Optymalizacja..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Aplikacja gotowa!"
echo "🌐 Aplikacja dostępna na:"
echo "   HTTPS: https://rcp.wbg.lodzkie.pl"
echo "   (HTTP przekierowuje automatycznie na HTTPS)"

# Uruchom Apache w trybie foreground
apache2-foreground

