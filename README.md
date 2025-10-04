<h1 align="center">
Expense Tracker
</h1>

![Expense Tracker](public/images/preview/preview.jpeg "Expense Tracker")

## Overview

This project is a web application designed to help users manage their finance by tracking their expenses. This project is built using Laravel 11, providing a robust and scalable backend framework.

## Features

-   User Authentication: Secure login and registration system with Laravel's built-in authentication system.
-   Dashboard: A user-friendly interface to view your financial summary at a glance.
-   Expense Management: Add, edit, and delete expense records.
-   Reports: Generate and download expense reports in various period.
-   Responsive Design: Fully responsive design that adapts to different screen sizes.

## Installation

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   Node.js and NPM

### Steps

1. Clone the repository

    ```bash
    git clone https://github.com/rtrivaldo/expense-tracker.git
    cd expense-tracker
    ```

2. Install dependencies

    ```bash
    composer install
    npm install
    ```

3. Environment setup
   Copy `.env.example` to `.env` and update the necessary variables.

    ```bash
    cp .env.example .env
    ```

4. Generate application key

    ```bash
    php artisan key:generate
    ```

5. Run migrations

    ```bash
    php artisan migrate
    ```

6. Run the development server

    ```bash
    npm run dev
    ```

## Usage

-   Register a new account or log in with existing credentials.
-   Navigate to the dashboard to view an overview of your expenses.
-   Add expense entries using the respective forms.
-   View reports to analyze your financial data over time.

## Contributing

If you would like to contribute to this project, feel free to fork the repository and submit a pull request.

## Author

-   [Rivaldo Tandoko](https://github.com/rtrivaldo)
# spendwise
