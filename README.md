# Fun with Vue & Laravel

Kurs Udemy przerobiony na aktualny stack: Laravel 13, Vue 3 + TypeScript,
Inertia 3, PostgreSQL 18 — wszystko w Dockerze (Laravel Sail).

- Aplikacja: **http://localhost:8010**
- Podgląd maili (Mailpit): **http://localhost:8030**

> Porty są nietypowe, bo domyślne (80, 5432, 6379) kolidują z innymi
> projektami działającymi w Dockerze. Ustawione w `.env`.

## Skrót: `sail`

Wszystkie komendy idą przez `./vendor/bin/sail`. Żeby nie pisać tego za każdym
razem, dodaj alias do `~/.bashrc` (raz, potem restart terminala):

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

Poniżej zakładam, że alias masz.

## Codzienna praca

```bash
sail up -d        # start (w tle)
sail npm run dev  # Vite — odpal w drugiej zakładce i zostaw na czas kodowania
sail down         # stop
```

`sail up -d` odpala kontenery, `npm run dev` pilnuje plików Vue/CSS i odświeża
przeglądarkę. Bez `npm run dev` zmiany we frontendzie nie będą widoczne.

## Zasada numer jeden

PHP, Composer i Node **żyją w kontenerze**, nie na twoim komputerze. Dlatego
każdą komendę z kursu poprzedzasz `sail`:

| Instruktor mówi | Ty wpisujesz |
|---|---|
| `php artisan migrate` | `sail artisan migrate` |
| `composer require ...` | `sail composer require ...` |
| `npm install` | `sail npm install` |
| `php artisan test` | `sail test` |

## Baza danych

```bash
sail artisan migrate           # migracje
sail artisan migrate:fresh --seed  # kasuje wszystko i sieje od nowa
sail psql                      # konsola Postgresa (interaktywna)
sail artisan db:show           # szybki test: czy baza odpowiada
```

Z zewnątrz (np. TablePlus / DBeaver) baza jest na `localhost:54320`,
user `sail`, hasło `password`, baza `app`.

## Kiedy coś nie działa

```bash
sail ps                  # co żyje, a co padło
sail logs -f             # logi na żywo (Ctrl+C wychodzi)
sail down && sail up -d  # klasyczne wyłącz-włącz
```

Jeśli `sail up` krzyczy **"port is already allocated"** — inny projekt zajął
port. Sprawdź czym: `docker ps`, i albo zatrzymaj tamten projekt, albo zmień
port w `.env`.

Po zmianach w `compose.yaml` albo w `.env` (porty, wersje):

```bash
sail down && sail build --no-cache && sail up -d
```

## Wejście do kontenera

```bash
sail shell    # bash w kontenerze aplikacji
sail tinker   # konsola PHP Laravela
```
