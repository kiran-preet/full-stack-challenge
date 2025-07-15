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
3. **Build and start containers:**
   ```sh
   docker-compose up --build
   ```
4. **Install frontend dependencies:**
   ```sh
   npm install
   ```
5. **Run Vite dev server (in another terminal):**
   ```sh
   npm run dev
   ```
6. **Access the app:**
   - Backend: http://localhost:8000
   - Frontend: http://localhost:5173 (if using Vite dev server)

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
- Built by [Your Name]
- Forked from [Original Repo]

---
For more details, see code comments and individual config files.
# Wise Publishing Challenge 👨‍💻

This challenge is meant to measure your capabilities as a **full stack developer** and assess your approach to solving problems. We value clean code, and good user experience.

We appreciate adherence to **SOLID**, **KISS**, and **DRY** principles and encourage a focus on performance, **Core Web Vitals (CWV)**, and UI/UX skills.

We expect that an MVP (Minimum Viable Product) of this challenge will take roughly 3-4 hours. However, you will have 2 business days to complete the task.

## Project Name: **WiseJobs** 🦉

### Requirements ⚙️

This project will use **Laravel** (as a backend framework) and **Alpine.js**, **JS with Typescript**, **HTML**, **CSS**, and **Blade templating** for the frontend.

Optionally, you can utilize Inertia JS with React or Vue.

You are tasked with creating a responsive, performant, and user-friendly job board application called WiseJobs.

### Users 👥

**Users should be able to:**
- Scroll through the list of the latest published jobs.
- Filter jobs based on: position type (remote or in-person), salary, company, and location.
- View more details for each individual job.
- **Performance Consideration:** Ensure smooth scrolling, fast page loading, and efficient job filtering.
- **UI/UX Consideration:** The list should be easy to navigate, with clear, user-friendly job cards, and filters should be intuitive and accessible.

### Admin users 🗣️
**Admins should be able to:**
* Create companies.
* View all companies and the number of postings for each company.
* View a single company.
* Update a company.
* Delete a company and all of its postings.
* Create job postings for a selected company.
* View a single job posting.
* Update a job posting.  
* Delete a job posting.
  
### Frontend Expectations 🤘

1. **UI/UX:**
   - **Responsive Design:** Ensure the application is fully responsive across all devices (mobile, tablet, desktop).
   - **User-friendly Filters:** Implement an intuitive filtering UI with clear feedback when users apply filters.
   - **Microinteractions:** Add subtle animations or transitions to improve the user experience without impacting performance.
   - **Accessibility:** Ensure the site is accessible for all users (e.g., keyboard navigation, screen reader support).

2. **Frontend Architecture:**
   - **Reusable Components:** Build reusable components for job cards, filter options, and forms using Blade and Alpine.js.
   - **Separation of Concerns:** Ensure a clean separation between data fetching and UI rendering for scalability.
   - **CSS Architecture:** Use a CSS methodology such as BEM or utility-first CSS for maintainable and scalable styles.

3. **Extras (Optional but appreciated):**
   - **Dark Mode Toggle**: Provide a dark mode toggle for the job board.
   - **Hosting**: Deploy the application for extra points.

### Submission 📬

Please make sure to fork this repository and commit your code. We would like to see your commit history with clear, frequent commit messages. When you are completed with the challenge, feel free to share the repository link with us, along with a readme for getting started with the project. Ensure at least one commit is pushed at the 2-hour mark.
