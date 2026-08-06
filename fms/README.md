# TransRoute — Commercial Aviation Flight Management System

A fully dynamic Laravel + Blade application for managing flights, bookings, luggage, shipping, crew, and passenger notifications, built on a normalized MySQL schema. UI/UX is preserved from the original design (Material Design 3 tokens, Hanken Grotesk / Inter / IBM Plex Sans typography, the same color system, layout, and modals).

## Stack
- Laravel 10, PHP 8.1+
- MySQL (normalized schema, 3NF)
- Blade + Tailwind (CDN) + Alpine.js (CDN) — no build step required
- Session-based authentication, role middleware (`admin`, `passenger`)

## Roles & Permissions (as specified)

**Admin**
- Only admin can add luggage for passengers (passengers can only read and update status to "picked").
- Admin can cancel tickets for passengers who didn't turn up (marks `no_show`, ticket retained — never deleted).
- Only admin can add shipping records.
- Cancelled flights/tickets/luggage/shipments are never deleted — status flips to `cancelled`/`no_show` and they remain visible in the UI (greyed out, in a separate "Cancelled" section).
- Admin manages the Active Schedule Manifest (add / edit / cancel flights), which is the same data rendered live in the public website's Schedule section.

**Passenger**
- Can cancel their own tickets (only while the flight hasn't departed).
- Notified automatically: 30 minutes before takeoff, on arrival, when a booking is confirmed, and when a flight is delayed (`App\Services\NotificationService` + scheduled command `flights:notify`).
- Cannot add or alter luggage — only confirm pickup once status is `in_transit`.
- Cannot add or alter shipping — view-only, linked to their ticket.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your MySQL credentials, then:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Visit `http://localhost:8000`.

## Secrets & Credentials

Do NOT commit sensitive values (API keys, passwords, database credentials) into the repository. Use the provided `.env.example` as a template and keep your actual values in a local `.env` file which is ignored by Git. In production, prefer environment variables managed by your hosting platform or a secrets manager, and rotate credentials regularly.

Quick checklist:
- Keep `fms/.env` out of version control (already listed in `.gitignore`).
- Use `fms/.env.example` for onboarding and docs.
- Rotate DB credentials if they were ever committed or shared.
- For CI/CD or container runs, inject secrets via the platform's secure variables instead of embedding them in files.

## Seeded accounts (all passwords: `password`)
- Admin: `admin@transroute.com` → `/admin/login`
- Passenger: `sarah.j@example.com`, `marcus.t@example.com`, `john.doe@example.com`, `alex.rivera@example.com` → `/login`

## Automatic notifications

Run the scheduler (or call manually for testing):

```bash
php artisan flights:notify
```

In production, add to your crontab:
```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```
This checks every minute for flights departing in ~30 minutes and flights that just landed, and creates the relevant notifications for confirmed ticket holders. Booking confirmation, cancellation, and delay notifications fire immediately and synchronously when those admin actions happen.

## Database schema (normalized)

- `users` — admin + passenger accounts, role-based
- `airports` — IATA-style codes, city, country
- `flights` — flight_number, both airport FKs, times, gate, capacity, status
- `tickets` — passenger bookings, FK to flight + user, status lifecycle (pending → confirmed → completed, or cancelled/no_show)
- `luggages` — FK to ticket, admin-managed, status lifecycle
- `shipments` — FK to flight (+ optional ticket), admin-managed cargo
- `crew_members` + `flight_crew_member` pivot — crew roster, assignable to flights
- `flight_notifications` — per-user notification log (type, title, message, read state)

All cancellable entities use a `cancelled`/`no_show` enum status rather than hard deletes, satisfying the "don't delete, just show cancelled" requirement throughout.
