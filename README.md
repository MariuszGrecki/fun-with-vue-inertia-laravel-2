# Docker — komendy

```bash
# uruchom projekt
./vendor/bin/sail up -d

# aplikacja
# http://localhost:8010

# Vue/CSS — odpal w drugim terminalu podczas pracy
./vendor/bin/sail npm run dev

# zatrzymaj projekt
./vendor/bin/sail down
```

```bash
# Laravel
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan make:controller NazwaController
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
Host:     localhost
Port:     54320      <- nie 5432
User:     sail
Password: password
Database: app        <- nie postgres
```

```bash
# gdy coś nie działa
./vendor/bin/sail ps
./vendor/bin/sail logs -f
./vendor/bin/sail down
./vendor/bin/sail up -d
```

```bash
# po zmianie .env lub compose.yaml
./vendor/bin/sail down
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d
```
