# Hours: Self-Hosted Time Tracking

**Hours** is a simple, self-hosted web application designed for internal time tracking and basic payroll management. It allows an administrator to manage employees, log their work hours, and track payments.

The application is built using the TALL stack philosophy, heavily featuring **Laravel**, **Livewire**, and the **FluxUI** component library. It is containerized with **Docker** via **Laravel Sail** for a smooth, reproducible development environment.

---

## ✨ Features

The application's functionality is centered around three main models:

-   **Employee Management:**

    -   Add, edit, and manage employee profiles.
    -   Store basic information like name and default **hourly rate**.
    -   Set employees as active or inactive (archiving).

-   **Time Tracking (Hours):**

    -   Log work entries (hours) and assign them to specific employees.
    -   The system **automatically calculates** the total pay for each time entry based on the employee's set hourly rate.

-   **Payment Tracking (Payments):**

    -   Keep a record of all payments made by the administrator to an employee.
    -   Provides a clear overview of paid vs. unpaid hours.

-   **Advanced UI Components:**
    -   Features a custom, feature-rich data table for filtering, sorting, and managing records efficiently.

---

## 🛠️ Tech Stack

This project leverages a modern PHP stack with a focus on code quality and a streamlined development experience.

-   **Backend:** Laravel
-   **Frontend:** Livewire
-   **UI Kit:** FluxUI
-   **Development Environment:** Docker via Laravel Sail
-   **Testing:** Pest
-   **Static Analysis:** Larastan (configured to level 5)
-   **Code Styling:** Laravel Pint (for automated code formatting)
-   **CI / Code Review:** Coderabbit.ai, Gemini (provides automated AI-powered reviews on pull requests)

---

## 🚀 Getting Started

This application is designed to be run with Docker. You must have **Docker** and **Docker Compose** installed on your local machine.

### Standard Installation

1.  **Clone the repository:**

    ```bash
    git clone [https://github.com/koubevo/hours.git](https://github.com/koubevo/hours.git)
    cd hours
    ```

2.  **Install Composer Dependencies:**
    We use a small Docker container to run `composer install` without needing PHP or Composer on your host machine.

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs
    ```

3.  **Set up your environment:**
    Copy the example environment file and generate your application key.

    ```bash
    cp .env.example .env
    ```

    After this, you **must** review the `.env` file to set your database credentials and other local settings.

4.  **Start the Sail containers:**
    This command builds and starts all the necessary services (app, database, etc.) in the background.

    ```bash
    ./vendor/bin/sail up -d
    ```

5.  **Generate App Key & Run Migrations:**
    Once the containers are running, run the database migrations and (optionally) seed the database with test data.

    ```bash
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate --seed
    ```

6.  **Access the application:**
    You're all set! The application should now be running at [http://localhost](http://localhost) (or whatever `APP_PORT` you set in your `.env`).

### Developer Workflow Note

The project owner (`koubevo`) uses a local convenience script `appstart.sh` (aliased to `supDev`) to launch the development environment. This script is a personal wrapper, likely automating the `sail up` and `migrate` steps. For all other users, please follow the standard installation guide above.

---

## 🧪 Development & Tooling

This project uses several tools to ensure code quality. All commands should be run via Sail to execute them inside the Docker environment.

-   **Run Tests (Pest):**

    ```bash
    ./vendor/bin/sail pest
    ```

-   **Run Static Analysis (Larastan):**

    ```bash
    ./vendor/bin/phpstan analyse
    ```

-   **Check Code Style (Pint):**

    ```bash
    ./vendor/bin/sail pint --test
    ```

-   **Fix Code Style (Pint):**
    ```bash
    ./vendor/bin/sail pint
    ```

---

_This README file was generated with assistance from Google's Gemini assistant (Oct 2025 model), based on specifications provided by the project author._
