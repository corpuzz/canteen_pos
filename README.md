# Canteen POS

## How to run this app

1. After cloning the repository, nvigate to the root directory and install all the dependencies.
Open the terminal and run the following commands:

`npm install`
`composer install`

2. Set up the database, open Xampp Control Panel and start MySQL and Apache servers then run the migrations:

`php artisan migrate`

3. Run the seeders:

`php artisan db:seed`

4. Build the files and assets:

`npm run build`

5. Run the servers:

`npm run dev`
`php artisan serve`

6. Open your browser and go to http://localhost:8000

If images are not showing, run the following command:

`php artisan storage:link`

