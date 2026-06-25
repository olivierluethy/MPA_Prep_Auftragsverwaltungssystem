# 🐳 Mini-PA-Prep — Run with Docker

This project is fully dockerized: **PHP app + MySQL database + phpMyAdmin**.
You don't need PHP, Apache, MySQL or XAMPP installed — only **Docker**.
Everything (including a lot of test data) starts with a single command.

---

## 1. One-time requirement

Install Docker (Docker Engine + Compose). On Ubuntu:

```bash
sudo apt update && sudo apt install -y docker.io docker-compose-v2
sudo usermod -aG docker $USER     # then log out & back in once
```

Check it works:

```bash
docker --version
docker compose version
```

---

## 2. Start everything

From the project folder:

```bash
docker compose up -d --build
```

The first start takes ~1 minute (it downloads MySQL + phpMyAdmin and
automatically loads the schema **and lots of mock data**).

Stop it again any time with:

```bash
docker compose down            # stop (keeps the database)
docker compose down -v         # stop AND wipe the database (fresh data next start)
```

---

## 3. Open the app  👉 http://localhost:8100

| What | URL |
|------|-----|
| **The application** | <http://localhost:8100> |
| Login | <http://localhost:8100/login> |
| Orders | <http://localhost:8100/auftraege> |
| Employees | <http://localhost:8100/mitarbeiter> |

> The app is served at the root, so URLs are short (no project name in the path).
> Opening <http://localhost:8100> automatically forwards you to the login / overview.

### Login

The mock data already contains users. Log in with:

| Role | Email | Password |
|------|-------|----------|
| **Admin** (sees edit / delete / add buttons) | `admin@minipa.test` | `admin` |
| Normal user | `sarah.meier@minipa.test` *(also admin)* | `password` |
| Normal user | `anna.keller@minipa.test` | `password` |
| …any other `*@minipa.test` | (see phpMyAdmin) | `password` |

👉 Use **`admin@minipa.test` / `admin`** to see the full feature set.

---

## 4. Open the database  👉 http://localhost:8101

A ready-to-use **phpMyAdmin** web page is included:

**<http://localhost:8101>**

Log in there with either:

| User | Password | Notes |
|------|----------|-------|
| `root` | `root` | full access |
| `minipa` | `minipa` | the app's user |

The database is called **`minipaprep`** with two tables: `mitarbeiter`
(employees) and `auftraege` (orders).

### Prefer a desktop tool / the CLI?

MySQL is also exposed directly on your machine:

```text
Host:     127.0.0.1
Port:     3310
Database: minipaprep
User:     minipa   (or root)
Password: minipa   (or root)
```

Example with the MySQL CLI:

```bash
docker compose exec db mysql -uminipa -pminipa minipaprep
```

---

## 5. The mock data (for testing UI/UX)

On first start the database is filled automatically with:

- **14 employees** — including names with umlauts, very long names, an
  employee with no orders, and special characters, so you can spot layout
  problems quickly.
- **30 orders** — a deliberate mix of:
  - **overdue** orders (shown **red**) and **upcoming** ones (shown **green**),
  - **open** vs **done** status,
  - very short and very long descriptions (table-width stress test),
  - long titles, Unicode/emoji, and orders with no attachment.

This is intentionally "messy" so common UI/UX issues become obvious at a glance.

### Reset / reload the mock data

The data is loaded only when the database is empty. To start over fresh:

```bash
docker compose down -v
docker compose up -d --build
```

To edit the mock data, change the files in `docker/init/` and run the reset
above (the scripts there run automatically on a fresh database):

- `docker/init/01-schema.sql` — table structure
- `docker/init/02-seed.sql` — the mock rows

---

## 6. Editing the code

The project folder is mounted live into the container, so any change you make
to a `.php`, `.css` or `.js` file is visible **immediately** on refresh — no
rebuild needed. (Only rerun `--build` if you change the `Dockerfile`.)

---

## 7. Ports — change them if they clash

All ports live in the **`.env`** file. The defaults were chosen because
`80`, `3306`, `8080`, `8081` were already busy on this machine:

| Service | Default host port | `.env` variable |
|---------|------------------|-----------------|
| Web app | `8100` | `APP_PORT` |
| phpMyAdmin | `8101` | `PHPMYADMIN_PORT` |
| MySQL | `3310` | `DB_PORT` |

If a port is taken, edit `.env`, then `docker compose up -d` again.

---

## 8. Troubleshooting

| Problem | Fix |
|---------|-----|
| "port is already allocated" | Change the port in `.env`, then `docker compose up -d`. |
| App shows a DB connection error | Wait ~20 s on first start (MySQL is still initializing), then refresh. |
| Data looks wrong / want a clean slate | `docker compose down -v && docker compose up -d --build`. |
| See what's running | `docker compose ps` |
| Read the logs | `docker compose logs -f app` (or `db`, `phpmyadmin`) |

---

## Summary (TL;DR)

```bash
docker compose up -d --build      # start
# App   -> http://localhost:8100   (login: admin@minipa.test / admin)
# DB UI -> http://localhost:8101   (login: root / root)
docker compose down               # stop
```
