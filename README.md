# PhotoDuels

PhotoDuels is a sample application built with Laravel 4.
More information can be found [here](http://malte.wintner.ch).

## How to install

### Step 1: Install dependencies

After downloading the code the dependencies can be installed
by using Composer.

    composer install --dev

### Step 2: Configure environment

Laravel detects the application environment (e.g. "local", "staging",
"production") depending on your host name.
The host name can be linked to the desired environment by updating
**bootstrap/start.php**.

### Step 3: Configure database

Assuming that your environment is set to "local", the database settings
can be defined in **app/config/local/database.php**.

### Step 4: Populate database

Run the following commands to create and populate the database tables:

    php artian migrate
    php artisan db:seed

### Step 5: Adjust file permissions

The folders **app/storage** and **public/upload** should have write
permissions.
