Docker approach to run `artisan` commands with updated TLS/SNI support

Steps:

1. Build the image (from `fms` directory):

```bash
docker-compose -f docker-compose.migrate.yml build --no-cache
```

2. Run migrations against the Render external DB (reads `fms/.env`):

```bash
docker-compose -f docker-compose.migrate.yml run --rm migrate php artisan migrate --force
```

3. Verify migration status:

```bash
docker-compose -f docker-compose.migrate.yml run --rm migrate php artisan migrate:status
```

Notes:
- This mounts the local project into the container so the container uses the same code and `.env` as your workspace.
- The container includes `pdo_pgsql` and the system OpenSSL/libpq from the base image which typically supports SNI required by Render's managed Postgres.
- If Render's DB still rejects TLS, consider running these commands from the Render dashboard shell instead.
