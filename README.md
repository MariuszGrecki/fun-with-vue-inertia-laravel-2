# Docker — komendy

Serwer domowy: **192.168.8.194** (z laptopa uzywaj IP, nie localhost).

```bash
# uruchom projekt
docker compose up -d

# aplikacja
# http://192.168.8.194:8010     <- port 8010, samo IP nie zadziala
# http://192.168.8.194:8030     <- Mailpit (podglad maili)

# Vue/CSS — odpal w drugim terminalu podczas pracy
./vendor/bin/sail npm run dev

# zatrzymaj projekt
docker compose down
```

```bash
# Laravel
./vendor/bin/sail artisan list
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan make:controller NazwaController
./vendor/bin/sail artisan make:model Listing -m
./vendor/bin/sail artisan make:migration add_fields_to_listings_table
./vendor/bin/sail artisan migrate:status
./vendor/bin/sail artisan migrate:rollback --step=1
./vendor/bin/sail artisan test
./vendor/bin/sail tinker
```

```bash
# Composer i npm
./vendor/bin/sail composer require nazwa/pakietu
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

```bash
# baza danych
./vendor/bin/sail psql
./vendor/bin/sail artisan db:show
```

```
# podlaczenie z DataGrip / TablePlus / DBeaver
Host:     192.168.8.194   <- IP serwera, nie localhost
Port:     54320      <- nie 5432
User:     sail
Password: password
Database: app        <- nie postgres
```

```bash
# gdy coś nie działa
docker compose ps
docker compose logs -f
docker compose down
docker compose up -d
```

```bash
# po zmianie .env lub compose.yaml
docker compose down
docker compose build --no-cache
docker compose up -d
```

./vendor/bin/sail composer require barryvdh/laravel-debugbar --dev

./vendor/bin/sail composer require --dev barryvdh/laravel-ide-helper
./vendor/bin/sail artisan ide-helper:models
