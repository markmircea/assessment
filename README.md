# Yum! Brands Internal Dashboard

Internal dashboard for Yum! Brands franchise owners to view and manage store financial data across brands (Taco Bell, KFC, Pizza Hut).

## Tech Stack
Laravel 12
Livewire 4
Tailwind CSS
Laravel Breeze (authentication)

## Setup


composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate


Configure your `.env` with database credentials, then:


php artisan migrate --seed
php artisan storage:link


## Running


php artisan serve
php artisan queue:work
npm run dev


## Test Accounts


peter@yumbrands.test | password
dwane@yumbrands.test | password
shaggy@yumbrands.test | password
