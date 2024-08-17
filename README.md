# SmartWorkout - Gym Tracker

## Overview

**SmartWorkout** is a full-stack web application developed during a summer practice program in collaboration with NetRom Software. The application is built using PHP with the Symfony framework and Twig templating engine. The purpose of this app is to help users track their gym progress effortlessly, create and manage custom workouts, and monitor their performance over time.

## Features

- **Track Gym Progress:** Easily log your workouts and track progress over time.
- **Custom Exercises:** Define and categorize exercises by muscle groups or genres such as weightlifting, calisthenics, cardio, etc.
- **Workout Management:** Create custom workouts by adding your defined exercises.
- **Reps and Weights Tracking:** Keep track of the number of reps and weights lifted for each exercise.
- **Workout Statistics:** View detailed workout statistics to monitor your progress.
- **Exercise Recommendations:** (Optional) Set up Google API for video recommendations of exercises.

## Prerequisites

Make sure you have the following installed on your system:

- PHP 8.0 or higher
- Composer
- Node.js
- **Yarn** (for managing frontend assets)
- **Symfony CLI** (for serving the application locally)
- MySQL or any compatible database

## Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/NoNameMB10K/SmartWorkout.git
    cd SmartWorkout
    ```

2. **Install PHP dependencies:**
    ```bash
    composer install
    ```
   > **Note:** This step might take some time depending on your connection speed.

3. **Install Node.js dependencies:**
    ```bash
    yarn install
    ```

4. **Build frontend assets:**
    ```bash
    yarn build
    ```

### Configuration

Before running the application, you need to set up environment variables. Create a `.env` file in the project root and configure the following variables:

```plaintext
GOOGLE_API_KEY=your_google_api_key
GOOGLE_AUTH_CONFIG=your_google_auth_config
APP_ENV=dev
APP_SECRET=your_app_secret
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```

## Database Setup

### Create a MySQL database:

```sql
CREATE DATABASE smart_workout;
```

### Run database migrations:
```
php bin/console doctrine:migrations:migrate
```

### Load data fixtures (optional):
```
php bin/console doctrine:fixtures:load

```
> **Note:** If you run the fixtures, you can log in with the following credentials:
> - **Email:** `no@name.project`
> - **Password:** `noname`

## Running the Application
Start the Symfony local web server to run the application:
```
symfony serve
```

## Development

This project was developed over 3.5 weeks as part of a full-stack development practice program. The focus was on creating a functional and user-friendly web application that leverages modern PHP frameworks and best practices in web development.

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue for any improvements or bug fixes.

## Acknowledgments

Special thanks to **NetRom Software** for their guidance and support during the development of this project.


