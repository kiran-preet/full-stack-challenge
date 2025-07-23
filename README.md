---
# Project Implementation & Setup

A modern job board application built with Laravel, Inertia.js, Vue 3, Tailwind CSS, and Docker. Supports admin and public flows, job/company CRUD, filters, dark mode, and more.

## Features
- Laravel 10 backend (SQLite by default)
- Inertia.js SPA frontend with Vue 3
- Tailwind CSS with dark mode toggle
- Job and company CRUD (admin)
- Public job browsing, filtering, and infinite scroll (Load More)
- Responsive design
- File upload for company logos
- Flash messages and validation
- Dockerized development environment
- Vite for asset bundling

## Prerequisites
- Docker & Docker Compose
- Node.js & npm (for local frontend dev)

## Local Development (Docker)
1. **Clone the repository:**
   ```sh
   git clone <your-fork-url>
   cd job-board
   ```
2. **Copy .env file:**
   ```sh
   cp .env.example .env
   ```
3. Update env variables and vite configs
   - for local dev update .env 
      APP_URL=http://localhost:8000
      VITE_APP_URL=http://localhost:5173
   - vite.config.js
      remove https: true
      update base to http://localhost:5173
      and host to localhost

   -- You can start docker without following above step, it will build the project and run it.
3. **Build and start containers:**
   ```sh
   docker-compose up --build
   ```
4. **Access the app:**
   - Backend: http://localhost:8000
   - Frontend:http://localhost:5173 (if using Vite dev server)

5. For Admin login please update the username and password in /database/seeders/AdminUserSeederphp 
   The url is http://localhost:8000/login
## Database & Storage
- Uses SQLite by default (`database/database.sqlite`).
- Storage symlink for public file access:
  ```sh
  php artisan storage:link
  ```
- Seeders and factories available for demo data.

## Build for Production
1. **Build frontend assets:**
   ```sh
   npm run build
   ```
2. **Serve with Docker:**
   ```sh
   docker-compose up --build
   ```

## Useful Commands
- **Run migrations:**
  ```sh
  docker-compose exec app php artisan migrate
  ```
- **Run seeders:**
  ```sh
  docker-compose exec app php artisan db:seed
  ```
- **Run tests:**
  ```sh
  docker-compose exec app php artisan test
  ```

## Troubleshooting
- If you see `vendor/autoload.php` missing, ensure Composer dependencies are installed in the container.
- For dark mode issues, check `tailwind.config.cjs` for `darkMode: 'class'` and restart Vite/dev server.
- For merge conflicts, use `git status` and resolve files as needed.

## Project Structure
- `app/` - Laravel backend code
- `resources/js/` - Vue components, pages, layouts
- `resources/css/` - Tailwind CSS
- `database/` - Migrations, seeders, factories
- `public/` - Entry point, assets
- `Dockerfile`, `docker-compose.yml` - Container setup

## Credits
- Built by Kiranpreet
- Forked from https://github.com/Wise-Publishing-Inc/full-stack-challenge
