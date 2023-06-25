## System requirements:
PHP 8.1+, PHP SQLite lib, Git, NPM, Composer (PHP 8.1+)

## Install on Ubuntu:

1) Clone the repository: <b>git clone https://github.com/spitzer77/laravel-map-marker.git </b>
2) Enter the directory laravel-map-marker: <b>cd laravel-map-marker</b>
3) Install Composer dependencies: <b>composer install</b>
4) Install npm dependencies: <b>npm install</b>
5) Set appropriate permissions: <b>chmod 777 -R ./storage/</b>
6) Create a new SQLite database:
- <b>touch database/database.sqlite</b>
- <b>chmod 777 -R ./database/</b>
- <b>chmod 777 -R ./database/database.sqlite</b>
7) Run database migrations: <b>php artisan migrate</b>
8) Build the project: <b>npm run build</b>
9) Run laravel php webserver: <b>php artisan serve</b> or external running web server

## Install on Windows

1) Clone the repository: <b>git clone https://github.com/spitzer77/laravel-map-marker.git </b>
2) Enter the directory <b>laravel-map-marker</b>
3) Install Composer dependencies: <b>composer install</b>
4) Install npm dependencies: <b>npm install</b>
5) Run database migrations: <b>php artisan migrate</b> (say 'yes' to create sqlite database)
6) Build the project: <b>npm run build</b>
7) Run laravel php webserver: <b>php artisan serve</b> or external running web server

## Run test app:

1) Run page app (http://127.0.0.1:8000/markers on local machine or http://your_server:your_port/markers on external server)
2) Open the same link in another browser or in another tab of the current browser to observe both windows concurrently.
3) Set dummy marker coordinates with a longitude of 31.20 and a latitude of 50.80 to display it on the current map under the form.
4) After 1 minute, the marker will disappear from all open links.